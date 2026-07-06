<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\GuardianTypeFacade;
use App\Http\Requests\GuardianType\StoreGuardianTypeRequest;
use App\Http\Requests\GuardianType\UpdateGuardianTypeRequest;
use App\Http\Resources\GuardianType\GuardianTypeCollection;
use App\Http\Resources\GuardianType\GuardianTypeResource;

class GuardianTypeController extends Controller
{
    public function index()
    {
        return new GuardianTypeCollection(GuardianTypeFacade::getAll());
    }

    public function store(StoreGuardianTypeRequest $request)
    {
        $data = $request->validated();
        $model = GuardianTypeFacade::create($data);
        return new GuardianTypeResource($model);
    }

    public function show(int $id)
    {
        $model = GuardianTypeFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new GuardianTypeResource($model);
    }

    public function update(UpdateGuardianTypeRequest $request, int $id)
    {
        $data = $request->validated();
        $model = GuardianTypeFacade::update($id, $data);
        return new GuardianTypeResource($model);
    }

    public function destroy(int $id)
    {
        $response = GuardianTypeFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
