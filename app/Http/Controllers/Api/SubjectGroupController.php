<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\SubjectGroupService;
use App\Http\Requests\SubjectGroup\StoreSubjectGroupRequest;
use App\Http\Requests\SubjectGroup\UpdateSubjectGroupRequest;
use App\Http\Resources\SubjectGroup\SubjectGroupCollection;
use App\Http\Resources\SubjectGroup\SubjectGroupResource;
use App\Models\SubjectGroup;
use Illuminate\Http\Request;

class SubjectGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = app(SubjectGroupService::class)->getAll();
        return new SubjectGroupCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectGroupRequest $request)
    {
        $data = $request->validated();
        $subject = app(SubjectGroupService::class)->create($data);
        return new SubjectGroupResource($subject);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $subjectGroup = app(SubjectGroupService::class)->getById($id);
        if (!$subjectGroup) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new SubjectGroupResource($subjectGroup);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectGroupRequest $request, int $id)
    {
        $data = $request->validated();
        $subjectGroup = app(SubjectGroupService::class)->update($id, $data);
        return new SubjectGroupResource($subjectGroup);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(SubjectGroupService::class)->delete($id);
        return response(null, 204);
    }
}
