<?php

namespace App\Http\Controllers\Api;

use App\Traits\HasAdvancedFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Floor\StoreFloorRequest;
use App\Http\Requests\Floor\UpdateFloorRequest;
use App\Http\Resources\Floor\FloorCollection;
use App\Http\Resources\Floor\FloorResource;
use App\Http\Facades\FloorFacade;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    use HasAdvancedFilter;

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
        return new FloorCollection(FloorFacade::getAll($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFloorRequest $request)
    {
        $data = $request->validated();
        $floor = FloorFacade::create($data);
        return new FloorResource($floor);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $floor = FloorFacade::getById($id);
        if (!$floor) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new FloorResource($floor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFloorRequest $request, int $id)
    {
        $data = $request->validated();
        $floor = FloorFacade::update($id, $data);
        return new FloorResource($floor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $response = FloorFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
