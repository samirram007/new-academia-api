<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        return new SubjectGroupCollection(SubjectGroup::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectGroupRequest $request)
    {

        $data = $request->validated();
        $subject = SubjectGroup::create($data);
        return new SubjectGroupResource($subject);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubjectGroup $subjectGroup)
    {

        return new SubjectGroupResource($subjectGroup);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectGroupRequest $request, SubjectGroup $subjectGroup)
    {

        $data = $request->validated();
        $subjectGroup->update($data);
        return new SubjectGroupResource($subjectGroup);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubjectGroup $subjectGroup)
    {
        $subjectGroup->delete();
        return response(null, 204);
    }
}
