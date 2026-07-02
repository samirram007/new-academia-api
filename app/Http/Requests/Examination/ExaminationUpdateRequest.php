<?php

namespace App\Http\Requests\Examination;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExaminationUpdateRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('examinations', 'name')->ignore($this->route('examination'))
            ],
            'examination_type_id' => ['required', 'numeric', 'exists:examination_types,id'],
            'examination_start_date' => ['required', 'date'],
            'examination_end_date' => ['required', 'date'],
            'academic_session_id' => ['required', 'numeric', 'exists:academic_sessions,id'],
        ];
    }
}
