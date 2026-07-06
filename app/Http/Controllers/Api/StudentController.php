<?php

namespace App\Http\Controllers\Api;

use App\Traits\HasAdvancedFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreStudentRequest;
use App\Http\Requests\User\UpdateStudentRequest;
use App\Http\Resources\Student\StudentCollection;
use App\Http\Resources\Student\StudentResource;
use App\Http\Facades\StudentFacade;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use HasAdvancedFilter;

    public function index(Request $request)
    {
        return new StudentCollection(StudentFacade::getAll($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $data = $request->validated();
        $user = StudentFacade::create($data);
        return new StudentResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = StudentFacade::getById($id);
        if (!$user) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new StudentResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, int $id)
    {
        $data = $request->validated();
        $user = StudentFacade::update($id, $data);
        return new StudentResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $response = StudentFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
