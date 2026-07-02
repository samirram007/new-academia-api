<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Floor\StoreFloorRequest;
use App\Http\Requests\Floor\UpdateFloorRequest;
use App\Http\Resources\Floor\FloorCollection;
use App\Http\Resources\Floor\FloorResource;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    protected $userLoader=['building','building.campus'];
    public function index(Request $request)
    {
        $message=[];


        if(!$request->has('building_id')){
            array_push($message,'Please provide building_id');
        }
        if($message){
            return response()->json(
                [
                   'status'=>false,
                   'message' => $message
                ]
           , 400);
        }
        return new FloorCollection(Floor::with($this->userLoader)
        ->where('building_id',$request->input('building_id'))
        ->get());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFloorRequest $request)
    {
        $data = $request->validated();
        $floor = Floor::create($data);
        return new FloorResource($floor->load($this->userLoader));
    }

    /**
     * Display the specified resource.
     */
    public function show(Floor $floor)
    {

        return new FloorResource($floor->load($this->userLoader));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFloorRequest $request, Floor $floor)
    {
        $data = $request->validated();
        $floor->update($data);
        return new FloorResource($floor->load($this->userLoader));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Floor $floor)
    {
        $floor->delete();
        return response(null, 204);
    }
}
