<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\RoomTypeFacade;
use App\Http\Requests\RoomType\StoreRoomTypeRequest;
use App\Http\Requests\RoomType\UpdateRoomTypeRequest;
use App\Http\Resources\RoomType\RoomTypeCollection;
use App\Http\Resources\RoomType\RoomTypeResource;

class RoomTypeController extends Controller
{
    public function index()
    {
        return new RoomTypeCollection(RoomTypeFacade::getAll());
    }

    public function store(StoreRoomTypeRequest $request)
    {
        $data = $request->validated();
        $model = RoomTypeFacade::create($data);
        return new RoomTypeResource($model);
    }

    public function show(int $id)
    {
        $model = RoomTypeFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new RoomTypeResource($model);
    }

    public function update(UpdateRoomTypeRequest $request, int $id)
    {
        $data = $request->validated();
        $model = RoomTypeFacade::update($id, $data);
        return new RoomTypeResource($model);
    }

    public function destroy(int $id)
    {
        $response = RoomTypeFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
