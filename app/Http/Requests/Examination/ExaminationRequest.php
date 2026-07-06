<?php

namespace App\Http\Requests\Examination;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExaminationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:examinations,name'],
            'examination_type_id' => ['required', 'numeric', 'exists:examination_types,id'],
            'examination_start_date' => ['required', 'date'],
            'examination_end_date' => ['required', 'date'],
            'academic_session_id' => ['required', 'numeric', 'exists:academic_sessions,id'],
        ];

        if ($isUpdate) {
            $rules['name'] = ['required', 'string', 'max:255', Rule::unique('examinations', 'name')->ignore($this->route('examination'))];
        }

        return $rules;
    }
}
