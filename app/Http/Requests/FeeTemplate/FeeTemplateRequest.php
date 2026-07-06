<?php

namespace App\Http\Requests\FeeTemplate;

use Illuminate\Foundation\Http\FormRequest;

class FeeTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'is_active' => 'sometimes|boolean',
            'campus_id' => 'required|exists:campuses,id',
            'academic_class_id' => 'required|exists:academic_classes,id',
        ];
    }
}
