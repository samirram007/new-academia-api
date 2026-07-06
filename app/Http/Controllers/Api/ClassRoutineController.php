<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\ClassRoutineFacade;
use App\Http\Requests\ClassRoutine\StoreClassRoutineRequest;
use App\Http\Requests\ClassRoutine\UpdateClassRoutineRequest;
use App\Http\Resources\ClassRoutine\ClassRoutineCollection;
use App\Http\Resources\ClassRoutine\ClassRoutineResource;

class ClassRoutineController extends Controller
{
    public function index()
    {
        return new ClassRoutineCollection(ClassRoutineFacade::getAll());
    }

    public function store(StoreClassRoutineRequest $request)
    {
        $data = $request->validated();
        $model = ClassRoutineFacade::create($data);
        return new ClassRoutineResource($model);
    }

    public function show(int $id)
    {
        $model = ClassRoutineFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new ClassRoutineResource($model);
    }

    public function update(UpdateClassRoutineRequest $request, int $id)
    {
        $data = $request->validated();
        $model = ClassRoutineFacade::update($id, $data);
        return new ClassRoutineResource($model);
    }

    public function destroy(int $id)
    {
        $response = ClassRoutineFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
