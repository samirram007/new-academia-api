<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\AttendanceTypeFacade;
use App\Http\Requests\AttendanceType\StoreAttendanceTypeRequest;
use App\Http\Requests\AttendanceType\UpdateAttendanceTypeRequest;
use App\Http\Resources\AttendanceType\AttendanceTypeCollection;
use App\Http\Resources\AttendanceType\AttendanceTypeResource;

class AttendanceTypeController extends Controller
{
    public function index()
    {
        return new AttendanceTypeCollection(AttendanceTypeFacade::getAll());
    }

    public function store(StoreAttendanceTypeRequest $request)
    {
        $data = $request->validated();
        $model = AttendanceTypeFacade::create($data);
        return new AttendanceTypeResource($model);
    }

    public function show(int $id)
    {
        $model = AttendanceTypeFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new AttendanceTypeResource($model);
    }

    public function update(UpdateAttendanceTypeRequest $request, int $id)
    {
        $data = $request->validated();
        $model = AttendanceTypeFacade::update($id, $data);
        return new AttendanceTypeResource($model);
    }

    public function destroy(int $id)
    {
        $response = AttendanceTypeFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
