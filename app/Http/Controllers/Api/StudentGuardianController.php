<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\StudentGuardianFacade;
use App\Http\Requests\StudentGuardian\StoreStudentGuardianRequest;
use App\Http\Requests\StudentGuardian\UpdateStudentGuardianRequest;
use App\Http\Resources\StudentGuardian\StudentGuardianCollection;
use App\Http\Resources\StudentGuardian\StudentGuardianResource;

class StudentGuardianController extends Controller
{
    public function index()
    {
        return new StudentGuardianCollection(StudentGuardianFacade::getAll());
    }

    public function store(StoreStudentGuardianRequest $request)
    {
        $data = $request->validated();
        $model = StudentGuardianFacade::create($data);
        return new StudentGuardianResource($model);
    }

    public function show(int $id)
    {
        $model = StudentGuardianFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new StudentGuardianResource($model);
    }

    public function update(UpdateStudentGuardianRequest $request, int $id)
    {
        $data = $request->validated();
        $model = StudentGuardianFacade::update($id, $data);
        return new StudentGuardianResource($model);
    }

    public function destroy(int $id)
    {
        $response = StudentGuardianFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
