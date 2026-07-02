<?php

namespace App\Http\Controllers\Api;

use App\Models\SchoolType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolType\SchoolTypeResource;
use App\Http\Resources\SchoolType\SchoolTypeCollection;
use App\Http\Requests\SchoolType\StoreSchoolTypeRequest;
use App\Http\Requests\SchoolType\UpdateSchoolTypeRequest;

class SchoolTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return new SchoolTypeCollection(SchoolType::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolTypeRequest $request)
    {
        $data = $request->validated();
        $schoolType=SchoolType::create($data);
        return new SchoolTypeResource($schoolType);
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolType $schoolType)
    {

        return new SchoolTypeResource($schoolType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolTypeRequest $request,SchoolType $schoolType)
    {
        $data = $request->validated();
        $schoolType->update($data);
        return new SchoolTypeResource($schoolType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolType $schoolType)
    {
        $schoolType->delete();
        return response(null, 204);
    }
}
