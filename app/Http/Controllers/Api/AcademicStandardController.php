<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Services\AcademicStandardService;
use App\Http\Requests\AcademicStandard\AcademicStandardRequest;
use App\Http\Resources\AcademicStandard\AcademicStandardCollection;
use App\Http\Resources\AcademicStandard\AcademicStandardResource;
use App\Http\Facades\AcademicStandardFacade;
use Illuminate\Http\Request;
use JsonSerializable;

class AcademicStandardController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonSerializable
    {
        $data = app(AcademicStandardService::class)->getAll();
        return new AcademicStandardCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademicStandardRequest $request)
    {
        $data = $request->validated();
        $academicStandard = AcademicStandardFacade::create($data);
        return new AcademicStandardResource($academicStandard);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $academicStandard = AcademicStandardFacade::getById($id);
        if (!$academicStandard) {
            return response()->json(['message' => 'Academic standard not found'], 404);
        }
        return new AcademicStandardResource($academicStandard);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademicStandardRequest $request, int $id)
    {
        $data = $request->validated();
        $responseData = AcademicStandardFacade::update($id, $data);
        return new AcademicStandardResource($responseData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $response = AcademicStandardFacade::delete($id);
        if (!$response) {
            return $this->errorResponse('Academic standard not found', 404);
        }
        return response(null, 204);
    }
}
