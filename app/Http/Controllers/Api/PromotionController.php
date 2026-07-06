<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\PromotionService;
use App\Http\Resources\Promotion\PromotionResource;
use App\Http\Resources\Promotion\PromotionCollection;
use App\Http\Resources\Student\StudentCollection;
use App\Models\AcademicClass;
use App\Models\StudentSession;
use App\Models\User;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $data = app(PromotionService::class)->getAll();
        return new PromotionCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * Supports two modes:
     * 1. Batch promotion — expects { newData: {...}, students: [...] } (existing behavior)
     * 2. Single promotion — expects individual fields: student_id, old_*, new_*
     */
    public function store(Request $request)
    {
        // ── Single promotion mode ────────────────────────────────────────
        if ($request->has('student_id') && !$request->has('newData')) {
            $request->validate([
                'student_id' => 'required|exists:users,id',
                'old_academic_session_id' => 'sometimes|exists:academic_sessions,id',
                'new_academic_session_id' => 'required|exists:academic_sessions,id',
                'old_academic_class_id' => 'sometimes|exists:academic_classes,id',
                'new_academic_class_id' => 'required|exists:academic_classes,id',
                'old_campus_id' => 'sometimes|exists:campuses,id',
                'new_campus_id' => 'sometimes|exists:campuses,id',
            ]);

            // Create promotion record
            $promotion = app(PromotionService::class)->create($request->all());

            // Update old student session as promoted
            $oldStudentSession = StudentSession::where('student_id', $request->input('student_id'));

            if ($request->has('old_academic_session_id') && $request->input('old_academic_session_id')) {
                $oldStudentSession->where('academic_session_id', $request->input('old_academic_session_id'));
            }

            $oldStudentSession = $oldStudentSession->first();

            if ($oldStudentSession) {
                $oldStudentSession->is_promoted = 1;
                $oldStudentSession->save();
            }

            // Create or update new student session
            $newClass = AcademicClass::find($request->input('new_academic_class_id'));
            $existingNewSession = StudentSession::where('student_id', $request->input('student_id'))
                ->where('academic_session_id', $request->input('new_academic_session_id'))
                ->first();

            if ($existingNewSession) {
                $existingNewSession->academic_class_id = $request->input('new_academic_class_id');
                $existingNewSession->campus_id = $request->input('new_campus_id', $newClass?->campus_id);
                $existingNewSession->academic_standard_id = $newClass?->academic_standard_id;
                $existingNewSession->status = 2;
                $existingNewSession->save();
            } else {
                $studentSessionData = [
                    'student_id' => $request->input('student_id'),
                    'academic_session_id' => $request->input('new_academic_session_id'),
                    'academic_class_id' => $request->input('new_academic_class_id'),
                    'campus_id' => $request->input('new_campus_id', $newClass?->campus_id),
                    'academic_standard_id' => $newClass?->academic_standard_id,
                    'status' => 2,
                ];
                StudentSession::create($studentSessionData);
            }

            return new PromotionResource($promotion);
        }

        // ── Batch promotion mode (existing behavior) ─────────────────────
        $academic_class = AcademicClass::find($request->input('newData')['academic_class_id']);
        foreach ($request->input('students') as $key => $data) {
            $oldStudentSession = StudentSession::find($data['previous_student_session_id']);
            $studentSessionData = [];
            $studentSession = $data['new_student_session_id'] ? StudentSession::find($data['new_student_session_id']) : new StudentSession();

            $studentSessionData['student_id'] = $data['student_id'];
            $studentSessionData['previous_student_session_id'] = $data['previous_student_session_id'];
            $studentSessionData['academic_session_id'] = $request->input('newData')['academic_session_id'];
            $studentSessionData['academic_class_id'] = $request->input('newData')['academic_class_id'];
            $studentSessionData['campus_id'] = $academic_class->campus_id;
            $studentSessionData['academic_standard_id'] = $academic_class->academic_standard_id;
            $studentSessionData['status'] = 2;
            $studentSessionData['section_id'] = $oldStudentSession->section_id;

            $checkExist = StudentSession::where('student_id', $data['student_id'])
                ->where('academic_session_id', $request->input('newData')['academic_session_id'])
                ->first();

            if ($checkExist) {
                $studentSession = $checkExist;
                $studentSession->update($studentSessionData);
            } else {
                $studentSession = StudentSession::create($studentSessionData);
            }

            $oldStudentSession->is_promoted = 1;
            $oldStudentSession->next_student_session_id = $studentSession->id;
            $oldStudentSession->save();
        }

        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Promotions processed successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $promotion = app(PromotionService::class)->getById($id);
        if (!$promotion) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Promotion not found',
            ], 404);
        }
        return new PromotionResource($promotion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'student_id' => 'sometimes|exists:users,id',
            'promotion_no' => 'sometimes|string|max:255',
            'promotion_date' => 'sometimes|date',
            'old_academic_session_id' => 'sometimes|exists:academic_sessions,id',
            'new_academic_session_id' => 'sometimes|exists:academic_sessions,id',
            'old_academic_class_id' => 'sometimes|exists:academic_classes,id',
            'new_academic_class_id' => 'sometimes|exists:academic_classes,id',
            'old_campus_id' => 'sometimes|exists:campuses,id',
            'new_campus_id' => 'sometimes|exists:campuses,id',
            'is_active' => 'sometimes|boolean',
        ]);

        $promotion = app(PromotionService::class)->update($id, $request->all());
        return new PromotionResource($promotion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $response = app(PromotionService::class)->delete($id);
        if (!$response) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Promotion not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'code' => 204,
            'message' => 'Promotion deleted',
        ], 204);
    }
}
