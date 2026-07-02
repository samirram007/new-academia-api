<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;
use App\Http\Resources\Building\BuildingCollection;
use App\Http\Resources\Building\BuildingResource;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    protected $userLoader=['campus'];
    public function index(Request $request)
    {
        $message=[];


        if(!$request->has('campus_id')){
            array_push($message,'Please provide campus_id');
        }
        if($message){
            return response()->json(
                [
                   'status'=>false,
                   'message' => $message
                ]
           , 400);
        }
        return new BuildingCollection(Building::with($this->userLoader)
        ->where('campus_id',$request->input('campus_id'))
        ->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBuildingRequest $request)
    {
        $data = $request->validated();
        $building = Building::create($data);
        return new BuildingResource($building->load($this->userLoader));
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {

        return new BuildingResource($building->load($this->userLoader));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBuildingRequest $request, Building $building)
    {
        $data = $request->validated();
        $building->update($data);
        return new BuildingResource($building->load($this->userLoader));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        $building->delete();
        return response(null, 204);
    }
}
