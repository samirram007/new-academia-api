<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Designation\StoreDesignationRequest;
use App\Http\Requests\Designation\UpdateDesignationRequest;
use App\Http\Resources\Designation\DesignationCollection;
use App\Http\Resources\Designation\DesignationResource;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return new DesignationCollection(Designation::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDesignationRequest $request)
    {
        $data = $request->validated();
        $designation = Designation::create($data);
        return new DesignationResource($designation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {

        return new DesignationResource($designation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDesignationRequest $request, Designation $designation)
    {
        $data = $request->validated();
        $designation->update($data);
        return new DesignationResource($designation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        $designation->delete();
        return response(null, 204);
    }
}
