<?php

namespace App\Http\Controllers\Api;

use App\Http\Facades\SchoolTypeFacade;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Services\SchoolTypeService;

use Illuminate\Http\Request;
use App\Http\Resources\SchoolType\SchoolTypeResource;
use App\Http\Resources\SchoolType\SchoolTypeCollection;
use App\Http\Requests\SchoolType\SchoolTypeRequest;

class SchoolTypeController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data = SchoolTypeFacade::getAll();

        return new SchoolTypeCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchoolTypeRequest $request)
    {
        $data = $request->validated();
        $schoolType = app(SchoolTypeService::class)->create($data);
        return new SchoolTypeResource($schoolType);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $schoolType = app(SchoolTypeService::class)->getById($id);
        if (!$schoolType) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new SchoolTypeResource($schoolType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchoolTypeRequest $request, int $id)
    {
        $data = $request->validated();
        $schoolType = app(SchoolTypeService::class)->update($id, $data);
        return new SchoolTypeResource($schoolType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(SchoolTypeService::class)->delete($id);
        return response(null, 204);
    }
}
