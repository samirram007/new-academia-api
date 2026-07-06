<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Http\Resources\Room\RoomCollection;
use App\Http\Resources\Room\RoomResource;
use App\Http\Services\RoomService;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $data = app(RoomService::class)->getAll();
        return new RoomCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        $data = $request->validated();
        $room = app(RoomService::class)->create($data);
        return new RoomResource($room->load(app(RoomService::class)->getResource()));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $room = app(RoomService::class)->getById($id);
        if (!$room) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new RoomResource($room->load(app(RoomService::class)->getResource()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, int $id)
    {
        $data = $request->validated();
        $room = app(RoomService::class)->update($id, $data);
        return new RoomResource($room->load(app(RoomService::class)->getResource()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(RoomService::class)->delete($id);
        return response(null, 204);
    }
}
