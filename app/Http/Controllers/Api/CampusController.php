<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Campus\CampusRequest;
use App\Http\Resources\Campus\CampusCollection;
use App\Http\Resources\Campus\CampusResource;
use App\Http\Facades\CampusFacade;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $query = CampusFacade::getAll($request);
        return new CampusCollection($query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CampusRequest $request)
    {

        $data = $request->validated();
        $campus = CampusFacade::create($data);
        return new CampusResource($campus);
    }

    /**
     * Display the specified resource.
     */
    public function show($campusId)
    {
        $campus = CampusFacade::getById($campusId);
        return new CampusResource($campus);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CampusRequest $request, $campusId)
    {
        $data = $request->validated();
        $campus = CampusFacade::update($campusId, $data);

        return new CampusResource($campus);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($campusId)
    {
        CampusFacade::delete($campusId);
        return response(null, 204);
    }
}
