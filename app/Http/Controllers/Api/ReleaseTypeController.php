<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\ReleaseTypeFacade;
use App\Http\Requests\ReleaseType\StoreReleaseTypeRequest;
use App\Http\Requests\ReleaseType\UpdateReleaseTypeRequest;
use App\Http\Resources\ReleaseType\ReleaseTypeCollection;
use App\Http\Resources\ReleaseType\ReleaseTypeResource;

class ReleaseTypeController extends Controller
{
    public function index()
    {
        return new ReleaseTypeCollection(ReleaseTypeFacade::getAll());
    }

    public function store(StoreReleaseTypeRequest $request)
    {
        $data = $request->validated();
        $model = ReleaseTypeFacade::create($data);
        return new ReleaseTypeResource($model);
    }

    public function show(int $id)
    {
        $model = ReleaseTypeFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new ReleaseTypeResource($model);
    }

    public function update(UpdateReleaseTypeRequest $request, int $id)
    {
        $data = $request->validated();
        $model = ReleaseTypeFacade::update($id, $data);
        return new ReleaseTypeResource($model);
    }

    public function destroy(int $id)
    {
        $response = ReleaseTypeFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
