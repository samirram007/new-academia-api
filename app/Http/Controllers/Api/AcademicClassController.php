<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;

use App\Http\Requests\AcademicClass\AcademicClassRequest;
use App\Http\Resources\AcademicClass\AcademicClassCollection;
use App\Http\Resources\AcademicClass\AcademicClassResource;
use App\Http\Facades\AcademicClassFacade;
use Illuminate\Http\Request;

class AcademicClassController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {

        return new AcademicClassCollection(AcademicClassFacade::getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademicClassRequest $request)
    {
        $data = $request->validated();
        $academicClass = AcademicClassFacade::create($data);
        return new AcademicClassResource($academicClass);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $academicClass = AcademicClassFacade::getById($id);
        if (!$academicClass) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new AcademicClassResource($academicClass);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademicClassRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $result = AcademicClassFacade::update($id, $data);
            return new AcademicClassResource($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage(),
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (AcademicClassFacade::delete($id)) {
            return response()->json(['message' => 'Academic class deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Academic class not found'], 404);
        }
    }
}
