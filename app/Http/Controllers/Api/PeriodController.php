<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\PeriodFacade;
use App\Http\Requests\Period\StorePeriodRequest;
use App\Http\Requests\Period\UpdatePeriodRequest;
use App\Http\Resources\Period\PeriodCollection;
use App\Http\Resources\Period\PeriodResource;

class PeriodController extends Controller
{
    public function index()
    {
        return new PeriodCollection(PeriodFacade::getAll());
    }

    public function store(StorePeriodRequest $request)
    {
        $data = $request->validated();
        $model = PeriodFacade::create($data);
        return new PeriodResource($model);
    }

    public function show(int $id)
    {
        $model = PeriodFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new PeriodResource($model);
    }

    public function update(UpdatePeriodRequest $request, int $id)
    {
        $data = $request->validated();
        $model = PeriodFacade::update($id, $data);
        return new PeriodResource($model);
    }

    public function destroy(int $id)
    {
        $response = PeriodFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
