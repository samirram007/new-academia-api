<?php

namespace App\Http\Requests\ExaminationStandard;

use Illuminate\Foundation\Http\FormRequest;

class ExaminationStandardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'academic_standard_id' => $isUpdate ? ['sometimes', 'required', 'numeric'] : ['required', 'numeric'],
            'examination_id' => $isUpdate ? ['sometimes', 'required', 'numeric'] : ['required', 'numeric'],
        ];
    }
}
