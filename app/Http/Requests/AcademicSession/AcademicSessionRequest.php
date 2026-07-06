<?php

namespace App\Http\Requests\AcademicSession;

use Illuminate\Foundation\Http\FormRequest;

class AcademicSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'session' => $isUpdate ? ['sometimes', 'required'] : ['required'],
            'start_date' => $isUpdate ? ['sometimes', 'nullable', 'date'] : ['required', 'date'],
            'end_date' => ['sometimes', 'nullable', 'date', 'after:start_date'],
            'previous_academic_session_id' => ['sometimes', 'nullable', 'numeric', 'exists:academic_sessions,id'],
            'next_academic_session_id' => ['sometimes', 'nullable', 'numeric', 'exists:academic_sessions,id'],
            'is_current' => ['sometimes', 'nullable', 'boolean'],
        ];
    }
}
