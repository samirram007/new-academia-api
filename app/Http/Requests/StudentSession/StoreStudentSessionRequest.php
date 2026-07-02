<?php

namespace App\Http\Requests\StudentSession;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id'=>'required|integer|exists:users,id',
            'academic_session_id'=>'required|integer|exists:academic_sessions,id',
            'academic_class_id'=>'required|integer|exists:academic_classes,id',
            'is_idcard_printable'=>'sometimes|nullable|boolean',
            'idcard_print_count'=>'sometimes|nullable|integer|'

        ];
    }
}
