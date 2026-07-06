<?php

namespace App\Http\Requests\StudentSession;

use Illuminate\Foundation\Http\FormRequest;

class StudentSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        if ($isUpdate) {
            return [];
        }

        return [
            'student_id' => 'required|integer|exists:users,id',
            'academic_session_id' => 'required|integer|exists:academic_sessions,id',
            'academic_class_id' => 'required|integer|exists:academic_classes,id',
            'is_idcard_printable' => 'sometimes|nullable|boolean',
            'idcard_print_count' => 'sometimes|nullable|integer',
        ];
    }
}
