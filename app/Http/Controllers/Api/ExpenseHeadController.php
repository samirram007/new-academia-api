<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\ExpenseHeadService;
use App\Models\ExpenseHead;
use Illuminate\Http\Request;
use App\Http\Resources\ExpenseHead\ExpenseHeadResource;
use App\Http\Resources\ExpenseHead\ExpenseHeadCollection;
use App\Http\Requests\ExpenseHead\StoreExpenseHeadRequest;
use App\Http\Requests\ExpenseHead\UpdateExpenseHeadRequest;

class ExpenseHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = app(ExpenseHeadService::class)->getAll();
        return new ExpenseHeadCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseHeadRequest $request)
    {
        $data = $request->validated();
        $expense_head = app(ExpenseHeadService::class)->create($data);
        return new ExpenseHeadResource($expense_head);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $expense_head = app(ExpenseHeadService::class)->getById($id);
        if (!$expense_head) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new ExpenseHeadResource($expense_head);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseHeadRequest $request, int $id)
    {
        $data = $request->validated();
        $expense_head = app(ExpenseHeadService::class)->update($id, $data);
        return new ExpenseHeadResource($expense_head);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(ExpenseHeadService::class)->delete($id);
        return response(null, 204);
    }
}
