<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponseTrait;
use App\Traits\HasAdvancedFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicSession\AcademicSessionRequest;
use App\Http\Resources\AcademicSession\AcademicSessionCollection;
use App\Http\Resources\AcademicSession\AcademicSessionResource;
use App\Http\Facades\AcademicSessionFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use JsonSerializable;

class AcademicSessionController extends Controller
{
    use HasAdvancedFilter;
    use ApiResponseTrait;


    public function index(Request $request)
    {
        return new AcademicSessionCollection(AcademicSessionFacade::getAll($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademicSessionRequest $request)
    {
        $data = $request->validated();
        $academicSession = AcademicSessionFacade::create($data);
        return new AcademicSessionResource($academicSession);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $academicSession = AcademicSessionFacade::getById($id);
        return new AcademicSessionResource($academicSession);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademicSessionRequest $request, int $id)
    {
        $data = $request->validated();
        $responseData = AcademicSessionFacade::update($id, $data);
        return new AcademicSessionResource($responseData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $response = AcademicSessionFacade::delete($id);
        if (!$response) {
            return $this->errorResponse('Academic session not found', 404);
        }
        return response(null, 204);
    }
}
