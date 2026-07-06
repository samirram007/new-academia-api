<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\CampusAcademicSessionFacade;
use App\Http\Requests\CampusAcademicSession\StoreCampusAcademicSessionRequest;
use App\Http\Requests\CampusAcademicSession\UpdateCampusAcademicSessionRequest;
use App\Http\Resources\CampusAcademicSession\CampusAcademicSessionCollection;
use App\Http\Resources\CampusAcademicSession\CampusAcademicSessionResource;

class CampusAcademicSessionController extends Controller
{
    public function index()
    {
        return new CampusAcademicSessionCollection(CampusAcademicSessionFacade::getAll());
    }

    public function store(StoreCampusAcademicSessionRequest $request)
    {
        $data = $request->validated();
        $model = CampusAcademicSessionFacade::create($data);
        return new CampusAcademicSessionResource($model);
    }

    public function show(int $id)
    {
        $model = CampusAcademicSessionFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new CampusAcademicSessionResource($model);
    }

    public function update(UpdateCampusAcademicSessionRequest $request, int $id)
    {
        $data = $request->validated();
        $model = CampusAcademicSessionFacade::update($id, $data);
        return new CampusAcademicSessionResource($model);
    }

    public function destroy(int $id)
    {
        $response = CampusAcademicSessionFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
