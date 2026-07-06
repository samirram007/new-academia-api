<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\RoleFacade;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Role\RoleCollection;
use App\Http\Resources\Role\RoleResource;

class RoleController extends Controller
{
    public function index()
    {
        return new RoleCollection(RoleFacade::getAll());
    }

    public function store(StoreRoleRequest $request)
    {
        $data = $request->validated();
        $model = RoleFacade::create($data);
        return new RoleResource($model);
    }

    public function show(int $id)
    {
        $model = RoleFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new RoleResource($model);
    }

    public function update(UpdateRoleRequest $request, int $id)
    {
        $data = $request->validated();
        $model = RoleFacade::update($id, $data);
        return new RoleResource($model);
    }

    public function destroy(int $id)
    {
        $response = RoleFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
