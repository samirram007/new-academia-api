<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Http\Resources\Room\RoomCollection;
use App\Http\Resources\Room\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $userLoader=['floor','floor.building','floor.building.campus'];
    public function index(Request $request)
    {
        $message=[];


        if(!$request->has('floor_id')){
            array_push($message,'Please provide floor_id');
        }
        if($message){
            return response()->json(
                [
                   'status'=>false,
                   'message' => $message
                ]
           , 400);
        }
        return new RoomCollection(Room::with($this->userLoader)
        ->where('floor_id',$request->input('floor_id'))
        ->get());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {

        $data = $request->validated();
        $room = Room::create($data);
       // dd($room);
        return new RoomResource($room->load($this->userLoader));
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {

        return new RoomResource($room->load($this->userLoader));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $data = $request->validated();
        $room->update($data);
        return new RoomResource($room->load($this->userLoader));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return response(null, 204);
    }
}
