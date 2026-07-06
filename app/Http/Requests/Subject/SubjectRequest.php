<?php

namespace App\Http\Requests\Subject;

use App\Enums\SubjectTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['sometimes', 'string', 'max:20'],
            'description' => ['sometimes', 'nullable', 'string'],
            'subject_type' => $isUpdate
                ? ['sometimes', 'required', Rule::in(SubjectTypeEnum::cases())]
                : ['required', Rule::in(SubjectTypeEnum::cases())],
            'subject_group_id' => $isUpdate
                ? ['sometimes', 'required', 'exists:subject_groups,id']
                : ['required', 'exists:subject_groups,id'],
            'academic_standard_id' => $isUpdate
                ? ['sometimes', 'required', 'exists:academic_standards,id']
                : ['required', 'exists:academic_standards,id'],
            'logo_image_id' => ['sometimes', 'nullable', 'exists:documents,id'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
