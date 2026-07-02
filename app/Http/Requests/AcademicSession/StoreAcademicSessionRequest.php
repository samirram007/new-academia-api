<?php

namespace App\Http\Requests\AcademicSession;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAcademicSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'session' => ['required'  ],
            'start_date' => ['required', 'date'],
            'end_date' => ['sometimes', 'nullable', 'date', 'after:start_date'],
            'previous_academic_session_id' => ['sometimes', 'nullable', 'numeric', 'exists:academic_sessions,id'],
            'next_academic_session_id' => ['sometimes', 'nullable', 'numeric', 'exists:academic_sessions,id'],
            'is_current' => ['sometimes', 'nullable', 'boolean'],

        ];
    }
}
