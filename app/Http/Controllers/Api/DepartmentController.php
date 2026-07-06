<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Services\DepartmentService;
use App\Http\Requests\Department\DepartmentRequest;
use App\Http\Resources\Department\DepartmentCollection;
use App\Http\Resources\Department\DepartmentResource;
use App\Http\Facades\DepartmentFacade;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = app(DepartmentService::class)->getAll();
        return new DepartmentCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        $data = $request->validated();
        $department = DepartmentFacade::create($data);
        return new DepartmentResource($department->load(DepartmentFacade::getResource()));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $department = DepartmentFacade::getById($id);
        if (!$department) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new DepartmentResource($department->load(DepartmentFacade::getResource()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, $id)
    {
        $data = $request->validated();
        $department = DepartmentFacade::update($id, $data);
        return new DepartmentResource($department->load(DepartmentFacade::getResource()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DepartmentFacade::delete($id);
        return response(null, 204);
    }
}
