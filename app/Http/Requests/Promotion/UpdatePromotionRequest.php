<?php

namespace App\Http\Requests\Promotion;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'promotion_no' => ['sometimes', 'nullable', 'string', 'max:255'],
            'promotion_date' => ['sometimes', 'nullable', 'date'],
            'student_id' => ['sometimes', 'numeric', 'exists:users,id'],
            'old_student_session_id' => ['sometimes', 'nullable', 'numeric', 'exists:student_sessions,id'],
            'old_campus_id' => ['sometimes', 'nullable', 'numeric', 'exists:campuses,id'],
            'old_academic_session_id' => ['sometimes', 'nullable', 'numeric', 'exists:academic_sessions,id'],
            'old_academic_class_id' => ['sometimes', 'nullable', 'numeric', 'exists:academic_classes,id'],
            'old_academic_standard_id' => ['sometimes', 'nullable', 'numeric', 'exists:academic_standards,id'],
            'new_student_session_id' => ['sometimes', 'nullable', 'numeric', 'exists:student_sessions,id'],
            'new_campus_id' => ['sometimes', 'nullable', 'numeric', 'exists:campuses,id'],
            'new_academic_session_id' => ['sometimes', 'nullable', 'numeric', 'exists:academic_sessions,id'],
            'new_academic_class_id' => ['sometimes', 'nullable', 'numeric', 'exists:academic_classes,id'],
            'new_academic_standard_id' => ['sometimes', 'nullable', 'numeric', 'exists:academic_standards,id'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
