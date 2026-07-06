<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\CountryFacade;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Http\Resources\Country\CountryCollection;
use App\Http\Resources\Country\CountryResource;

class CountryController extends Controller
{
    public function index()
    {
        return new CountryCollection(CountryFacade::getAll());
    }

    public function store(StoreCountryRequest $request)
    {
        $data = $request->validated();
        $model = CountryFacade::create($data);
        return new CountryResource($model);
    }

    public function show(int $id)
    {
        $model = CountryFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new CountryResource($model);
    }

    public function update(UpdateCountryRequest $request, int $id)
    {
        $data = $request->validated();
        $model = CountryFacade::update($id, $data);
        return new CountryResource($model);
    }

    public function destroy(int $id)
    {
        $response = CountryFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
