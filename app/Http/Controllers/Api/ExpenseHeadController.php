<?php

namespace App\Http\Controllers\Api;

use App\Models\ExpenseHead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseHead\ExpenseHeadResource;
use App\Http\Resources\ExpenseHead\ExpenseHeadCollection;
use App\Http\Requests\ExpenseHead\StoreExpenseHeadRequest;
use App\Http\Requests\ExpenseHead\UpdateExpenseHeadRequest;

class ExpenseHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ExpenseHeadCollection(ExpenseHead::with(['expense_group'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseHeadRequest $request)
    {
        $data = $request->validated();
        $expense_head = ExpenseHead::create($data);
        return new ExpenseHeadResource($expense_head);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseHead $expense_head)
    {
        return new ExpenseHeadResource($expense_head);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseHeadRequest $request, ExpenseHead $expense_head)
    {
        $data = $request->validated();
        $expense_head->update($data);
        return new ExpenseHeadResource($expense_head);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( ExpenseHead $expense_head)
    {
        $expense_head->delete();
        return response(null, 204);
    }
}
