<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Services\BuildingService;
use App\Http\Requests\Building\BuildingRequest;
use App\Http\Resources\Building\BuildingCollection;
use App\Http\Resources\Building\BuildingResource;
use App\Http\Facades\BuildingFacade;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $data = app(BuildingService::class)->getAll();
        return new BuildingCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BuildingRequest $request)
    {
        $data = $request->validated();
        $building = BuildingFacade::create($data);
        return new BuildingResource($building->load(BuildingFacade::getResource()));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $building = BuildingFacade::getById($id);
        if (!$building) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new BuildingResource($building->load(BuildingFacade::getResource()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BuildingRequest $request, int $id)
    {
        $data = $request->validated();
        $building = BuildingFacade::update($id, $data);
        return new BuildingResource($building->load(BuildingFacade::getResource()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        BuildingFacade::delete($id);
        return response(null, 204);
    }
}
