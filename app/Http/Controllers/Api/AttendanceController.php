<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\AttendanceFacade;
use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Http\Resources\Attendance\AttendanceCollection;
use App\Http\Resources\Attendance\AttendanceResource;

class AttendanceController extends Controller
{
    public function index()
    {
        return new AttendanceCollection(AttendanceFacade::getAll());
    }

    public function store(StoreAttendanceRequest $request)
    {
        $data = $request->validated();
        $model = AttendanceFacade::create($data);
        return new AttendanceResource($model);
    }

    public function show(int $id)
    {
        $model = AttendanceFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new AttendanceResource($model);
    }

    public function update(UpdateAttendanceRequest $request, int $id)
    {
        $data = $request->validated();
        $model = AttendanceFacade::update($id, $data);
        return new AttendanceResource($model);
    }

    public function destroy(int $id)
    {
        $response = AttendanceFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
