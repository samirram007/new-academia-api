<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Fee\FeeCollection;
use App\Http\Resources\Fee\FeeResource;
use App\Models\Fee;
use App\Models\FeeHead;
use App\Models\Month;
use App\Models\StudentSession;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function daily_collection_report(Request $request)
    {
        $message = [];

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
            ->whereBetween('fee_date', [$request->input('from'), $request->input('to')])
            ->orderBy('id', 'desc')
            ->get();

        $formattedFees = $fees->map(function ($fee) {
            $feeItems = $fee->fee_items->filter(function ($item) {
                return $item->amount > 0;
            })->map(function ($item) {
                return [
                    'fee_head_id' => $item->fee_head->id,
                    'fee_head_name' => $item->fee_head->name,
                    'total_amount' => $item->total_amount
                ];
            });

            $totalAmount = $fee->fee_items->sum('total_amount');

            return [
                'fee_date' => $fee->fee_date,
                'id' => $fee->id, // Assuming 'fee_no' is the fee's id, replace if needed
                'fee_no' => $fee->fee_no, // Assuming 'fee_no' is the fee's id, replace if needed
                'name' => $fee->student->name,
                'class' => $fee->student_session->academic_class->name,
                'section' => $fee->student_session->section->name,
                'roll_no' => $fee->student_session->roll_no,
                'fee_items' => $feeItems,
                'total' => $totalAmount,
            ];
        });
        return response()->json(["data" => $formattedFees], 200);
        // return new FeeCollection($fees);
    }
    public function monthly_fee_collection_report(Request $request)
    {
        $message = [];

        if (!$request->has('academic_session_id')) {
            array_push($message, 'Please provide academic_session_id');
        }
        // if (!$request->has('academic_class_id')) {
        //     array_push($message, 'Please provide academic_class_id');
        // }

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

        $feesQuery = Fee::with([
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
        ])
            ->where('academic_session_id', $request->academic_session_id)
            ->where('is_deleted', '!=', 1); // Exclude soft-deleted fees
        if ($request->has('academic_class_id')) {
            $feesQuery->whereHas('student_session', function ($query) use ($request) {
                $query->where('academic_class_id', $request->academic_class_id);
            });
        }
        if ($request->has('section_id')) {
            $feesQuery->whereHas('student_session', function ($query) use ($request) {
                $query->where('section_id', $request->section_id);
            });
        }
        $fees = $feesQuery->get();
        // Fetch all months
        $months = Month::all();

        // Initialize the collection structure
        $reportData = [];
        $students = [];

        foreach ($fees as $fee) {
            $student = $fee->student;
            $studentSession = $fee->student_session;
            $feeItems = $fee->fee_items;

            // Check if the student is already processed
            if (!array_key_exists($student->id, $students)) {
                // Initialize student data
                $students[$student->id] = [
                    'id' => $student->id,
                    'class' => $studentSession->academic_class->name,
                    'roll_no' => $studentSession->roll_no, // Assuming this is correct
                    'section' => $studentSession->section->name, // Assuming this is correct
                    'session' => $studentSession->academic_session->session, // Assuming this is correct
                    'student_name' => $student->name,
                    'months' => [], // Initialize months as an array
                ];

                // Populate months array with dynamic month headers
                foreach ($months as $month) {
                    // Initialize month data structure
                    $students[$student->id]['months'][] = [
                        'id' => $month->id,
                        'name' => $month->name,
                        'short_name' => strtolower(substr($month->name, 0, 3)),
                        'fee_no' => null,
                        'fee_date' => null,
                        'amount' => 0,
                    ];
                }
            }

            // Process fee items for the student
            foreach ($feeItems as $item) {
                foreach ($item->fee_item_months as $itemMonth) {
                    $monthId = $itemMonth->month->id;
                    // Find the corresponding month in the student's months array
                    foreach ($students[$student->id]['months'] as &$monthData) {
                        if ($monthData['id'] == $monthId) {
                            // Populate month data for the fee items
                            $monthData['fee_id'] = $fee->id;
                            $monthData['fee_no'] = $fee->fee_no;
                            $monthData['fee_date'] = $fee->fee_date;
                            $monthData['amount'] = $itemMonth->amount;
                            break;
                        }
                    }
                }
            }
        }

        // Convert the students associative array to an indexed array for JSON response
        $reportData = array_values($students);
        // order by roll_no
        usort($reportData, function ($a, $b) {
            return $a['roll_no'] <=> $b['roll_no'];
        });

        // Return the data in a JSON response
        return response()->json(['data' => $reportData]);
    }
    public function exam_fees_collection_report(Request $request)
    {
        $message = [];

        if (!$request->has('academic_session_id')) {
            array_push($message, 'Please provide academic_session_id');
        }
        // if (!$request->has('academic_class_id')) {
        //     array_push($message, 'Please provide academic_class_id');
        // }

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
        // 'fee_template',
        // 'academic_session',
        // 'student',
        // 'academic_class',
        // 'campus',
        // 'student_session',
        // 'student_session.campus',
        // 'student_session.academic_class',
        // 'student_session.academic_session',
        // 'student_session.section',
        // 'fee_items',
        $resource = [
            'fee_items.fee_head',
        ];

        $feesQuery = Fee::with($resource)
            ->where('academic_session_id', $request->academic_session_id)
            ->where('is_deleted', '!=', 1); // Exclude soft-deleted fees;
        if ($request->has('academic_class_id')) {
            $feesQuery->whereHas('student_session', function ($query) use ($request) {
                $query->where('academic_class_id', $request->academic_class_id);
            });
        }
        if ($request->has('section_id')) {
            $feesQuery->whereHas('student_session', function ($query) use ($request) {
                $query->where('section_id', $request->section_id);
            });
        }
        $fees = $feesQuery->get();
        //dump('Total Fees Fetched: ' . $fees->count());

        // Initialize the collection structure
        $reportData = [];
        $students = [];

        foreach ($fees as $fee) {
            $student = $fee->student;
            $studentSession = $fee->student_session;
            $feeItems = $fee->fee_items;
            // dump(!array_key_exists($student->id, $students));

            // Check if the student is already processed
            if (!array_key_exists($student->id, $students)) {
                if ($student->id === 11900 && $fee->id === 24952) {
                    dump($feeItems->toArray());
                }
                // Initialize student data
                $students[$student->id] = [
                    'id' => $student->id,
                    'class' => $studentSession->academic_class->name,
                    'roll_no' => $studentSession->roll_no, // Assuming this is correct
                    'section' => $studentSession->section->name, // Assuming this is correct
                    'session' => $studentSession->academic_session->session, // Assuming this is correct
                    'student_name' => $student->name,
                    'examFees' => [], // Initialize months as an array
                ];
                // if ($student->id === 11900) {
                //     dump($fee->toArray());
                // }
                // if feesItem has fee_head of type exam then populate examFees array

            }
            foreach ($feeItems as $item) {

                // dump($item->fee_head_id);
                if ($item->fee_head_id === 10383) {
                    $students[$student->id]['examFees'][] = [
                        'fee_id' => $fee->id,
                        'fee_no' => $fee->fee_no,
                        'fee_head_name' => $item->fee_head->name,
                        'fee_date' => $fee->fee_date,
                        'amount' => $item->total_amount,
                    ];
                }

            }


        }

        // Convert the students associative array to an indexed array for JSON response
        $reportData = array_values($students);
        // order by roll_no
        usort($reportData, function ($a, $b) {
            return $a['roll_no'] <=> $b['roll_no'];
        });

        // Return the data in a JSON response
        return response()->json(['data' => $reportData]);
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

}
