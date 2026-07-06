<?php

namespace App\Http\Requests\ClassRoutine;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassRoutineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'day_of_week' => ['sometimes', 'string', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'academic_session_id' => ['sometimes', 'numeric', 'exists:academic_sessions,id'],
            'academic_class_id' => ['sometimes', 'numeric', 'exists:academic_classes,id'],
            'subject_id' => ['sometimes', 'numeric', 'exists:subjects,id'],
            'teacher_id' => ['sometimes', 'numeric', 'exists:users,id'],
            'room_id' => ['sometimes', 'numeric', 'exists:rooms,id'],
            'start_time' => ['sometimes', 'date_format:H:i'],
            'end_time' => ['sometimes', 'date_format:H:i', 'after:start_time'],
        ];
    }
}
