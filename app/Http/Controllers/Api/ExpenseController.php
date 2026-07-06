<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Http\Requests\Expense\UpdateExpenseRequest;
use App\Http\Resources\Expense\ExpenseCollection;
use App\Http\Resources\Expense\ExpenseResource;
use App\Models\AcademicSession;
use App\Models\Expense;
use App\Http\Services\ExpenseService;
use App\Models\ExpenseItem;
use DB;
use Exception;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $data = app(ExpenseService::class)->getAll();
        return new ExpenseCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        try {

            $expense = new Expense();
            DB::transaction(function () use ($request) {
            $data = $request->validated();
            $academicSession = AcademicSession::where('id', $request['academic_session_id'])->first();
            $data['expense_no'] = $academicSession->current_expense_no;
            $expense = Expense::create($data);
            //  dd($data['expense_items']);
            foreach ($data['expense_items'] as $key => $expenseItem) {

                $expense_item = new ExpenseItem();
                $expense_item->expense_id = $expense->id;
                $expense_item->expense_head_id = $expenseItem['expense_head_id'];
                $expense_item->quantity = $expenseItem['quantity'];

                $expense_item->amount = $expenseItem['amount'];
                $expense_item->total_amount = $expenseItem['total_amount'];
                // dd($expense_items);
                $expense_item->save();
            }
            $academicSession->current_expense_no = $academicSession->current_expense_no+1;
            $academicSession->update();
            });
            return new ExpenseResource($expense->load(app(ExpenseService::class)->getResource()));
        } catch (Exception $e) {
        return response()->json(['error' => 'Check you input(s)'], 401);
    }
    }
    public function GetExpenseNo($academic_session_id)
    {
        $academicSession = AcademicSession::where('id', $academic_session_id)->first();
        $current_expense_no = $academicSession;

        return $current_expense_no;

    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        // return new ExpenseResource($expense->load($this->resource));
        $expense = Expense::with(
            'academic_session',
            'user',
            'expense_items',
            'expense_items.expense_head',
        )->find($expense->id);
        return new ExpenseResource($expense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        //dd($request->all());
        try {


            DB::transaction(function () use ($request, $expense) {
            $data = $request->validated();
            $expense->update($data);
                // dd($expense);
            foreach ($data['expense_items'] as $key => $expenseItem) {
                $expense_item = ExpenseItem::where('expense_id', $expense->id)->where('expense_head_id', $expenseItem['expense_head_id'])->first();
                if (!$expense_item) {
                    $expense_item = new ExpenseItem();
                }

                $expense_item->expense_id = $expense->id;
                $expense_item->expense_head_id = $expenseItem['expense_head_id'];
                $expense_item->quantity = $expenseItem['quantity'];
                $expense_item->amount = $expenseItem['amount'];
                $expense_item->total_amount = $expenseItem['total_amount'];

                $expense_item->save();
            }
            });
            return new ExpenseResource($expense->load(app(ExpenseService::class)->getResource()));

        } catch (Exception $e) {
        return response()->json(['error' => 'Check you input(s)'], 401);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return response(null, 204);
    }
}
