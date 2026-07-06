<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\StateFacade;
use App\Http\Requests\State\StoreStateRequest;
use App\Http\Requests\State\UpdateStateRequest;
use App\Http\Resources\State\StateCollection;
use App\Http\Resources\State\StateResource;

class StateController extends Controller
{
    public function index()
    {
        return new StateCollection(StateFacade::getAll());
    }

    public function store(StoreStateRequest $request)
    {
        $data = $request->validated();
        $model = StateFacade::create($data);
        return new StateResource($model);
    }

    public function show(int $id)
    {
        $model = StateFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new StateResource($model);
    }

    public function update(UpdateStateRequest $request, int $id)
    {
        $data = $request->validated();
        $model = StateFacade::update($id, $data);
        return new StateResource($model);
    }

    public function destroy(int $id)
    {
        $response = StateFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
