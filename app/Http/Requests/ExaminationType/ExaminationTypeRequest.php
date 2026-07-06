<?php

namespace App\Http\Requests\ExaminationType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExaminationTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name' => $isUpdate
                ? ['required', 'string', 'max:255', Rule::unique('examination_types', 'name')->ignore($this->route('examination_type'))]
                : ['required', 'string', 'max:255', 'unique:examination_types,name'],
            'is_promotional_exam' => ['required', 'boolean'],
        ];
    }
}
