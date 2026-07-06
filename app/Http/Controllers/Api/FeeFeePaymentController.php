<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\FeeFeePaymentFacade;
use App\Http\Requests\FeeFeePayment\StoreFeeFeePaymentRequest;
use App\Http\Requests\FeeFeePayment\UpdateFeeFeePaymentRequest;
use App\Http\Resources\FeeFeePayment\FeeFeePaymentCollection;
use App\Http\Resources\FeeFeePayment\FeeFeePaymentResource;

class FeeFeePaymentController extends Controller
{
    public function index()
    {
        return new FeeFeePaymentCollection(FeeFeePaymentFacade::getAll());
    }

    public function store(StoreFeeFeePaymentRequest $request)
    {
        $data = $request->validated();
        $model = FeeFeePaymentFacade::create($data);
        return new FeeFeePaymentResource($model);
    }

    public function show(int $id)
    {
        $model = FeeFeePaymentFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new FeeFeePaymentResource($model);
    }

    public function update(UpdateFeeFeePaymentRequest $request, int $id)
    {
        $data = $request->validated();
        $model = FeeFeePaymentFacade::update($id, $data);
        return new FeeFeePaymentResource($model);
    }

    public function destroy(int $id)
    {
        $response = FeeFeePaymentFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
