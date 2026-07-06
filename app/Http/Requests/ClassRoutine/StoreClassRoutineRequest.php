<?php

namespace App\Http\Requests\ClassRoutine;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRoutineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'day_of_week' => ['required', 'string', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'academic_session_id' => ['required', 'numeric', 'exists:academic_sessions,id'],
            'academic_class_id' => ['required', 'numeric', 'exists:academic_classes,id'],
            'subject_id' => ['required', 'numeric', 'exists:subjects,id'],
            'teacher_id' => ['required', 'numeric', 'exists:users,id'],
            'room_id' => ['sometimes', 'numeric', 'exists:rooms,id'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ];
    }
}
