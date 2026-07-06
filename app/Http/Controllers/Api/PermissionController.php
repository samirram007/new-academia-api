<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\PermissionFacade;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Http\Resources\Permission\PermissionCollection;
use App\Http\Resources\Permission\PermissionResource;

class PermissionController extends Controller
{
    public function index()
    {
        return new PermissionCollection(PermissionFacade::getAll());
    }

    public function store(StorePermissionRequest $request)
    {
        $data = $request->validated();
        $model = PermissionFacade::create($data);
        return new PermissionResource($model);
    }

    public function show(int $id)
    {
        $model = PermissionFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new PermissionResource($model);
    }

    public function update(UpdatePermissionRequest $request, int $id)
    {
        $data = $request->validated();
        $model = PermissionFacade::update($id, $data);
        return new PermissionResource($model);
    }

    public function destroy(int $id)
    {
        $response = PermissionFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
