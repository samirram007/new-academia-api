<?php

namespace App\Http\Requests\AcademicClass;

use Illuminate\Foundation\Http\FormRequest;

class AcademicClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {


        $rules = [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'code' => ['sometimes', 'required', 'string', 'max:255'],
            'campus_id' => ['sometimes', 'required', 'integer', 'exists:campuses,id'],
            'academic_standard_id' => ['sometimes', 'required', 'integer', 'exists:academic_standards,id'],
            'capacity' => ['sometimes', 'required', 'integer'],
        ];

        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $rules['name'] = ['sometimes', 'required', 'string', 'max:255'];
            $rules['code'] = ['sometimes', 'required', 'string', 'max:255'];
        }

        return $rules;
    }
}
