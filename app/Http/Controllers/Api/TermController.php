<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\TermFacade;
use App\Http\Requests\Term\StoreTermRequest;
use App\Http\Requests\Term\UpdateTermRequest;
use App\Http\Resources\Term\TermCollection;
use App\Http\Resources\Term\TermResource;

class TermController extends Controller
{
    public function index()
    {
        return new TermCollection(TermFacade::getAll());
    }

    public function store(StoreTermRequest $request)
    {
        $data = $request->validated();
        $model = TermFacade::create($data);
        return new TermResource($model);
    }

    public function show(int $id)
    {
        $model = TermFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new TermResource($model);
    }

    public function update(UpdateTermRequest $request, int $id)
    {
        $data = $request->validated();
        $model = TermFacade::update($id, $data);
        return new TermResource($model);
    }

    public function destroy(int $id)
    {
        $response = TermFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
