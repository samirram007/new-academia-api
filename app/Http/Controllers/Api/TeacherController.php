<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Teacher\TeacherCollection;
use App\Http\Resources\Teacher\TeacherResource;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    protected $resourceLoader = [];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with($this->resourceLoader)
            ->where('user_type', 'teacher')
            ->get();
        return new TeacherCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        return new TeacherResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with($this->resourceLoader)
            ->where('user_type', 'teacher')
            ->find($id);
        return new TeacherResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validated();
        $user = User::find($id);
        $user->update($data);
        return new TeacherResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->noContent();
    }
}
