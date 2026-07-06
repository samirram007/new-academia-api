<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\School\SchoolRequest;
use App\Http\Resources\School\SchoolCollection;
use App\Http\Resources\School\SchoolResource;
use App\Http\Services\SchoolService;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $data = app(SchoolService::class)->getAll();
        return new SchoolCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchoolRequest $request)
    {
        $data = $request->validated();
        $school = app(SchoolService::class)->create($data);
        $resource = app(SchoolService::class)->getResource();
        return new SchoolResource($school->load($resource));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $school = app(SchoolService::class)->getById($id);
        if (!$school) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $resource = app(SchoolService::class)->getResource();
        return new SchoolResource($school->load($resource));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchoolRequest $request, int $id)
    {
        $data = $request->validated();
        $school = app(SchoolService::class)->update($id, $data);
        return new SchoolResource($school);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(SchoolService::class)->delete($id);
        return response(null, 204);
    }
}
