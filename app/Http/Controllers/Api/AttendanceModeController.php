<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\AttendanceModeFacade;
use App\Http\Requests\AttendanceMode\StoreAttendanceModeRequest;
use App\Http\Requests\AttendanceMode\UpdateAttendanceModeRequest;
use App\Http\Resources\AttendanceMode\AttendanceModeCollection;
use App\Http\Resources\AttendanceMode\AttendanceModeResource;

class AttendanceModeController extends Controller
{
    public function index()
    {
        return new AttendanceModeCollection(AttendanceModeFacade::getAll());
    }

    public function store(StoreAttendanceModeRequest $request)
    {
        $data = $request->validated();
        $model = AttendanceModeFacade::create($data);
        return new AttendanceModeResource($model);
    }

    public function show(int $id)
    {
        $model = AttendanceModeFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new AttendanceModeResource($model);
    }

    public function update(UpdateAttendanceModeRequest $request, int $id)
    {
        $data = $request->validated();
        $model = AttendanceModeFacade::update($id, $data);
        return new AttendanceModeResource($model);
    }

    public function destroy(int $id)
    {
        $response = AttendanceModeFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
