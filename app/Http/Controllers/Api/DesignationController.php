<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Services\DesignationService;
use App\Http\Requests\Designation\DesignationRequest;
use App\Http\Resources\Designation\DesignationCollection;
use App\Http\Resources\Designation\DesignationResource;
use App\Http\Facades\DesignationFacade;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    use ApiResponseTrait;


    public function index(Request $request)
    {
        $data = app(DesignationService::class)->getAll();
        return new DesignationCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DesignationRequest $request)
    {
        $data = $request->validated();
        $designation = DesignationFacade::create($data);
        return new DesignationResource($designation);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $designation = DesignationFacade::getById($id);
        return new DesignationResource($designation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DesignationRequest $request, int $id)
    {
        $data = $request->validated();
        $designation = DesignationFacade::update($id, $data);
        return new DesignationResource($designation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        DesignationFacade::delete($id);
        return response(null, 204);
    }
}
