<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subject\StoreSubjectRequest;
use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Http\Resources\Subject\SubjectCollection;
use App\Http\Resources\Subject\SubjectResource;
use App\Http\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $data = app(SubjectService::class)->getAll();
        return new SubjectCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        $data = $request->validated();
        $subject = app(SubjectService::class)->create($data);
        return new SubjectResource($subject->load(app(SubjectService::class)->getResource()));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $subject = app(SubjectService::class)->getById($id);
        if (!$subject) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new SubjectResource($subject->load(app(SubjectService::class)->getResource()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, int $id)
    {
        $data = $request->validated();
        $subject = app(SubjectService::class)->update($id, $data);
        return new SubjectResource($subject->load(app(SubjectService::class)->getResource()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(SubjectService::class)->delete($id);
        return response(null, 204);
    }
}
