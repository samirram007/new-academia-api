<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fee\StoreFeeRequest;
use App\Http\Requests\Fee\UpdateFeeRequest;
use App\Http\Resources\Fee\FeeCollection;
use App\Http\Resources\Fee\FeeResource;
use App\Models\Fee;
use App\Models\FeeItem;
use App\Models\FeeItemMonth;
use App\Models\StudentSession;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $message = [];


        if (!$request->has('academic_session_id')) {
            array_push($message, 'Please provide academic_session_id');
        }
        if ($message) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $message,
                ]
                ,
                400
            );
        }
        $fees = Fee::with(
            'fee_template',
            'academic_session',
            'student',
            'academic_class',
            'campus',
            'student_session',
            'student_session.campus',
            'student_session.academic_class',
            'student_session.academic_session',
            'student_session.section',
            'student_session.fee_item_months',

            'fee_items',
            'fee_items.fee_head',
            'fee_items.fee_item_months',
            'fee_items.fee_item_months.month',
            'campus',
            'campus.school',
            'campus.school.address',
            'campus.school.logo_image'
        )
            ->where('academic_session_id', $request->academic_session_id)
            ->where('is_deleted', '!=', 1)
            ->whereBetween('fee_date', [$request->input('from'), $request->input('to')])
            ->orderBy('id', 'desc')
            ->get();

        return new FeeCollection($fees);
    }
    public function FeesByStudentSession(StudentSession $studentSession)
    {

        // $fees = Fee::with('fee_template', 'academic_session', 'student', 'academic_class', 'campus',
        //     'student_session', 'student_session.campus', 'student_session.academic_class',
        //     'student_session.academic_session', 'student_session.section',
        //     'student_session.fee_item_months',
        //     'fee_items',
        //      'fee_items.fee_head',
        //      'fee_items.fee_item_months',
        //      'fee_items.fee_item_months.month',
        //     'campus', 'campus.school', 'campus.school.address', 'campus.school.logo_image')
        //     ->where('student_id', $studentSession->student_id)
        //     ->where('academic_session_id', $studentSession->academic_session_id)
        //     ->orderBy('id', 'desc')
        //     ->get();
        $fees = Fee::with([
            'fee_template',
            'academic_session',
            'student',
            'academic_class',
            'campus',
            'student_session' => function ($query) {
                $query->with([
                    'campus',
                    'academic_class',
                    'academic_session',
                    'section',
                    'fee_item_months' => function ($query) {
                        $query->where('is_deleted', '!=', 1)->with(['month']);
                    },
                ]);
            },
            'fee_items' => function ($query) {
                $query->where('is_deleted', '!=', 1)
                    ->with([
                        'fee_head',
                        'fee_item_months' => function ($query) {
                            $query->where('is_deleted', '!=', 1)->with(['month']);
                        }
                    ]);
            },
            'campus.school',
            'campus.school.address',
            'campus.school.logo_image',
        ])
            ->where('is_deleted', '!=', 1) // Apply is_deleted condition to the main fees table
            ->where('student_id', $studentSession->student_id)
            ->where('academic_session_id', $studentSession->academic_session_id)
            ->orderBy('id', 'desc')
            ->get();
        return new FeeCollection($fees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeRequest $request)
    {

        try {

            $result = \DB::transaction(function () use ($request) {
                $data = $request->validated();

                if (in_array(strtolower($data['fee_no']), ['new', ''])) {
                    $data['fee_no'] = $this->GetFeeNo($data['academic_session_id']);
                }

                $fee = Fee::create($data);
                foreach ($data['fee_items'] as $key => $feeItem) {

                    $fee_item = new FeeItem();
                    $fee_item->fee_id = $fee->id;
                    $fee_item->fee_head_id = $feeItem['fee_head_id'];
                    $fee_item->quantity = $feeItem['quantity'];
                    $fee_item->keep_periodic_details = $feeItem['keep_periodic_details'];
                    $fee_item->is_customizable = $feeItem['is_customizable'];
                    $fee_item->is_active = $feeItem['is_active'];

                    if ($feeItem['keep_periodic_details']) {

                        $fee_item->months = $feeItem['months'] ?? ($feeItem['quantity'] . ($feeItem['quantity'] == 1 ? ' month' : ' months'));
                    }
                    $fee_item->amount = $feeItem['amount'];
                    $fee_item->total_amount = $feeItem['total_amount'];

                    $fee_item->save();
                    // dd($feeItem);
                    if ($feeItem['keep_periodic_details']) {

                        $fee_item_months = FeeItemMonth::where('student_session_id', $data['student_session_id'])
                            ->latest('month_id')->first();
                        $month_id = $fee_item_months ? $fee_item_months->month_id + 1 : 1;

                        for ($i = 0; $i < $feeItem['quantity']; $i++) {
                            $feeItem['fee_item_months'][$i]['student_session_id'] = $data['student_session_id'];
                            $feeItem['fee_item_months'][$i]['academic_session_id'] = $data['academic_session_id'];
                            $feeItem['fee_item_months'][$i]['fee_id'] = $fee->id;
                            $feeItem['fee_item_months'][$i]['student_id'] = $data['student_id'];
                            $feeItem['fee_item_months'][$i]['month_id'] = $month_id + $i;
                            $feeItem['fee_item_months'][$i]['amount'] = $feeItem['amount'];
                        }

                        $fee_item->fee_item_months()->createMany($feeItem['fee_item_months']);

                        $this->check_reset_item_months($data['student_session_id']);

                    }

                }

                return $fee;
            });
            return new FeeResource($result);

        } catch (\Exception $e) {
            // If any exception occurs, transaction will be rolled back
            return response()->json([
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage(),
            ], 500);
        }

    }
    private function GetFeeNo($academic_session_id)
    {
        $countFees = Fee::where('academic_session_id', $academic_session_id)
            ->orderByRaw('CONVERT(fee_no, UNSIGNED) DESC')
            ->first();

        return $countFees ? $countFees->fee_no + 1 : 1;

    }
    /**
     * Display the specified resource.
     */
    public function show(Fee $fee)
    {
        $fee = Fee::with(
            'fee_template',
            'academic_session',
            'student',
            'academic_class',
            'campus',
            'fee_items',
            'fee_items.fee_head',
            'campus.school',
            'campus.school.address',
            'campus.school.logo_image'
        )->find($fee->id);
        return new FeeResource($fee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeRequest $request, Fee $fee)
    {
        try {

            $result = \DB::transaction(function () use ($request, $fee) {
                $data = $request->validated();
                //throw new Exception("Failed to create student record.");
                $fee->update($data);

                $fee_items = FeeItem::where('fee_id', $fee->id)->get();

                foreach ($fee_items as $key => $item) {
                    $item['is_deleted'] = 1;
                    $item->save();
                }
                foreach ($data['fee_items'] as $key => $feeItem) {
                    $fee_item = FeeItem::where('fee_id', $fee->id)->where('fee_head_id', $feeItem['fee_head_id'])->first();
                    if (!$fee_item) {
                        $fee_item = new FeeItem();
                    }
                    $fee_item->fee_id = $fee->id;
                    $fee_item->fee_head_id = $feeItem['fee_head_id'];
                    $fee_item->quantity = $feeItem['quantity'];
                    $fee_item->amount = $feeItem['amount'];
                    $fee_item->total_amount = $feeItem['total_amount'];
                    $fee_item->keep_periodic_details = $feeItem['keep_periodic_details'];
                    $fee_item->is_customizable = $feeItem['is_customizable'];
                    $fee_item->is_active = $feeItem['is_active'];

                    $fee_item->is_deleted = 0;

                    $fee_item->save();
                    if ($feeItem['keep_periodic_details'] && $feeItem['amount'] > 0) {

                        $fee_item->fee_item_months()->delete();
                        $fee_item_months = FeeItemMonth::where('student_session_id', $data['student_session_id'])
                            ->latest('month_id')->first();
                        $month_id = $fee_item_months ? $fee_item_months->month_id + 1 : 1;

                        for ($i = 0; $i < $feeItem['quantity']; $i++) {
                            $feeItem['fee_item_months'][$i]['student_session_id'] = $data['student_session_id'];
                            $feeItem['fee_item_months'][$i]['academic_session_id'] = $data['academic_session_id'];
                            $feeItem['fee_item_months'][$i]['fee_id'] = $fee->id;
                            $feeItem['fee_item_months'][$i]['student_id'] = $data['student_id'];
                            $feeItem['fee_item_months'][$i]['month_id'] = $month_id + $i;
                            $feeItem['fee_item_months'][$i]['amount'] = $feeItem['amount'];
                        }
                        //$fee_item->fee_item_months()->delete();

                        $fee_item->fee_item_months()->createMany($feeItem['fee_item_months']);
                        $this->check_reset_item_months($data['student_session_id']);
                    }
                }

                return $fee;
            });
            return new FeeResource($result);

        } catch (\Exception $e) {
            // If any exception occurs, transaction will be rolled back
            return response()->json([
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage(),
            ], 500);
        }
        return response()->json(['error' => 'Check you input(s)'], 401);
    }

    public function check_reset_item_months($studentSessionId)
    {

        $current_month_id = 1;
        $fees = Fee::with([
            'fee_items' => function ($query) {
                $query->where('is_deleted', '!=', 1)
                    ->with([
                        'fee_head',
                        'fee_item_months' => function ($query) {
                            $query->where('is_deleted', '!=', 1)->with(['month']);
                        }
                    ]);
            },
            'fee_item_months' => function ($query) {
                $query->where('is_deleted', '!=', 1)->with(['month']);
            }
        ])
            ->where('student_session_id', $studentSessionId)
            ->where('is_deleted', '!=', 1)
            ->orderBy('fee_date', 'asc')->get();
        foreach ($fees as $key => $fee) {
            $feeItem = $fee->fee_items->where('keep_periodic_details', 1)->where('is_deleted', 0)->first();
            if (!$feeItem) {
                continue;
            }

            for ($i = 0; $i < $feeItem->quantity; $i++) {

                if ($feeItem['fee_item_months'][$i]['month_id'] == $current_month_id) {
                    $current_month_id++;
                } else {

                    $feeItem_month = FeeItemMonth::find($feeItem['fee_item_months'][$i]['id']);
                    $feeItem_month->student_session_id = $studentSessionId;
                    $feeItem_month->academic_session_id = $fee->academic_session_id;
                    $feeItem_month->fee_id = $fee->id;
                    $feeItem_month->student_id = $fee->student_id;
                    $feeItem_month->month_id = $current_month_id++;
                    $feeItem_month->amount = $feeItem['amount'];
                    $feeItem_month->save();

                }
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fee $fee)
    {
        // return new FeeResource($fee);
        try {

            $result = \DB::transaction(function () use ($fee) {

                $fee->fee_items()->update(['is_deleted' => 1]);
                $fee->fee_item_months()->update(['is_deleted' => 1]);
                $fee->update(['is_deleted' => 1, 'note' => 'Having deleted fee.']);

                $this->check_reset_item_months($fee->student_session_id);
                return $fee;
            });
            return new FeeResource($result);
        } catch (\Exception $e) {
            // If any exception occurs, transaction will be rolled back
            return response()->json([
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage(),
            ], 500);
        }
        // $fee->delete();
        // return response(null, 204);
    }
    public function softDelete(Fee $fee)
    {
        try {


            $result = \DB::transaction(function () use ($fee) {

                $fee->fee_items()->update(['is_deleted' => 1]);
                $fee->fee_item_months()->update(['is_deleted' => 1]);
                $fee->update(['is_deleted' => 1, 'note' => 'Having deleted fee.']);

                $this->check_reset_item_months($fee->student_session_id);
                return $fee;
            });
            return new FeeResource($result);
        } catch (\Exception $e) {
            // If any exception occurs, transaction will be rolled back
            return response()->json([
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage(),
            ], 500);
        }
        // $fee->delete();
        // return response(null, 204);
    }
}
