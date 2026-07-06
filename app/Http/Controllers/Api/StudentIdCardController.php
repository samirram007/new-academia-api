<?php

namespace App\Http\Controllers\Api;

use App\Traits\HasAdvancedFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Student\StudentCollection;
use App\Http\Resources\Student\StudentResource;
use App\Http\Facades\StudentIdCardFacade;
use App\Models\StudentSession;
use Illuminate\Http\Request;

class StudentIdCardController extends Controller
{
    use HasAdvancedFilter;

    public function index(Request $request)
    {
        return new StudentCollection(StudentIdCardFacade::getAll($request));
    }

    /**
     * Store a newly created resource in storage.
     * Enables ID card printing for a student in a given session/class.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'academic_class_id' => 'required|exists:academic_classes,id',
        ]);

        $studentSession = StudentSession::firstOrNew([
            'student_id' => $request->input('student_id'),
            'academic_session_id' => $request->input('academic_session_id'),
        ]);

        $studentSession->academic_class_id = $request->input('academic_class_id');
        $studentSession->is_idcard_printable = true;
        $studentSession->save();

        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'ID card printable status enabled',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $student = StudentIdCardFacade::getById($id);
        if (!$student) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     * Supports updating idcard_print_count and toggling is_idcard_printable.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'academic_class_id' => 'sometimes|exists:academic_classes,id',
            'is_idcard_printable' => 'sometimes|boolean',
            'idcard_print_count' => 'sometimes|integer|min:0',
        ]);

        $studentSession = StudentSession::where('student_id', $id)
            ->where('academic_session_id', $request->input('academic_session_id'))
            ->firstOrFail();

        if ($request->has('academic_class_id')) {
            $studentSession->academic_class_id = $request->input('academic_class_id');
        }
        if ($request->has('is_idcard_printable')) {
            $studentSession->is_idcard_printable = $request->boolean('is_idcard_printable');
        }
        if ($request->has('idcard_print_count')) {
            $studentSession->idcard_print_count = $request->input('idcard_print_count');
        }
        $studentSession->save();

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'ID card settings updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $query = StudentSession::where('student_id', $id);

        // If academic_session_id is provided, target that specific session
        if (request()->has('academic_session_id')) {
            $query->where('academic_session_id', request()->input('academic_session_id'));
        }

        $studentSession = $query->first();
        if (!$studentSession) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $studentSession->is_idcard_printable = false;
        $studentSession->idcard_print_count = 0;
        $studentSession->save();

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'ID card printable status reset',
        ]);
    }
}
