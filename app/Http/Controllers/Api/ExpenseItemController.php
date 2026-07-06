<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\ExpenseItemFacade;
use App\Http\Requests\ExpenseItem\StoreExpenseItemRequest;
use App\Http\Requests\ExpenseItem\UpdateExpenseItemRequest;
use App\Http\Resources\ExpenseItem\ExpenseItemCollection;
use App\Http\Resources\ExpenseItem\ExpenseItemResource;

class ExpenseItemController extends Controller
{
    public function index()
    {
        return new ExpenseItemCollection(ExpenseItemFacade::getAll());
    }

    public function store(StoreExpenseItemRequest $request)
    {
        $data = $request->validated();
        $model = ExpenseItemFacade::create($data);
        return new ExpenseItemResource($model);
    }

    public function show(int $id)
    {
        $model = ExpenseItemFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new ExpenseItemResource($model);
    }

    public function update(UpdateExpenseItemRequest $request, int $id)
    {
        $data = $request->validated();
        $model = ExpenseItemFacade::update($id, $data);
        return new ExpenseItemResource($model);
    }

    public function destroy(int $id)
    {
        $response = ExpenseItemFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
