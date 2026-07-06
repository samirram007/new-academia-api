<?php

namespace App\Http\Controllers\Api;

use App\Traits\HasAdvancedFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreTeacherRequest;
use App\Http\Requests\Teacher\UpdateTeacherRequest;
use App\Http\Resources\Teacher\TeacherCollection;
use App\Http\Resources\Teacher\TeacherResource;
use App\Http\Facades\TeacherFacade;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    use HasAdvancedFilter;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return new TeacherCollection(TeacherFacade::getAll($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {
        $data = $request->validated();
        $user = TeacherFacade::create($data);
        return new TeacherResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = TeacherFacade::getById($id);
        if (!$user) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new TeacherResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRequest $request, int $id)
    {
        $data = $request->validated();
        $user = TeacherFacade::update($id, $data);
        return new TeacherResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $response = TeacherFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
