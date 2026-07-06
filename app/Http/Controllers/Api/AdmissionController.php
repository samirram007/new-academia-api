<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\AdmissionFacade;
use App\Http\Resources\Admission\AdmissionCollection;
use App\Http\Resources\Admission\AdmissionResource;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index()
    {
        return new AdmissionCollection(AdmissionFacade::getAll());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $model = AdmissionFacade::create($data);
        return new AdmissionResource($model);
    }

    public function show(int $id)
    {
        $model = AdmissionFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new AdmissionResource($model);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
        ]);
        $model = AdmissionFacade::update($id, $data);
        return new AdmissionResource($model);
    }

    public function destroy(int $id)
    {
        $response = AdmissionFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
