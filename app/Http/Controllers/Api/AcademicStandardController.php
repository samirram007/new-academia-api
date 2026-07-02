<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicStandard\StoreAcademicStandardRequest;
use App\Http\Requests\AcademicStandard\UpdateAcademicStandardRequest;
use App\Http\Resources\AcademicStandard\AcademicStandardCollection;
use App\Http\Resources\AcademicStandard\AcademicStandardResource;
use App\Models\AcademicStandard;
use Illuminate\Http\Request;

class AcademicStandardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return new AcademicStandardCollection(AcademicStandard::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcademicStandardRequest $request)
    {
        $data = $request->validated();
        $academicStandard = AcademicStandard::create($data);
        return new AcademicStandardResource($academicStandard);
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicStandard $academicStandard)
    {
        return new AcademicStandardResource($academicStandard);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcademicStandardRequest $request, AcademicStandard $academicStandard)
    {
        $data = $request->validated();
        $academicStandard->update($data);
        return new AcademicStandardResource($academicStandard);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicStandard $academicStandard)
    {
        $academicStandard->delete();
        return response(null, 204);
    }
}
