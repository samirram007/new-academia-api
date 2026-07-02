<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\StudentCollection;
use App\Models\User;
use Illuminate\Http\Request;

class StudentIdCardController extends Controller
{
    protected $userLoader = ['academic_session',  'academic_class', 'campus', 'address', 'address.state', 'address.country', 'addresses', 'addresses.state', 'addresses.country',
    'designation', 'department', 'profile_document', 'guardians',
    'student_sessions', 'student_sessions.next_student_session',
    'student_sessions.previous_student_session',
    'student_sessions.academic_class',
    'student_sessions.academic_session',
     'student_sessions.section',
     'student_sessions.campus'];

protected $foreignLoader = ['student', 'student.profile_document', 'academic_session', 'academic_class', 'academic_standard'];
public function index(Request $request)
{
    $message = [];

    if (!$request->has('campus_id')) {
        array_push($message, 'Please provide campus');
    }
    if (!$request->has('academic_session_id')) {
        array_push($message, 'Please provide academic session');
    }
    if (!$request->has('academic_class_id')) {
        array_push($message, 'Please provide academic class');
    }
    if ($message) {
        return response()->json(
            [
                'status' => false,
                'message' => $message,
            ]
            , 400);
    }

    $users = User::with($this->userLoader)
        ->where('user_type', 'student')
        ->whereIn('id', function ($query) use ($request) {
            $query->select('student_id')
                ->from('student_sessions')
                ->whereIn('academic_session_id', [$request->input('academic_session_id')])
                ->whereIn('academic_class_id', [$request->input('academic_class_id')]);
        })->get();
    return new StudentCollection($users);

}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
