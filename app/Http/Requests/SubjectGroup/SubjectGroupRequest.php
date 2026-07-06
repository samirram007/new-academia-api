<?php

namespace App\Http\Requests\SubjectGroup;

use Illuminate\Foundation\Http\FormRequest;

class SubjectGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name' => $isUpdate ? ['sometimes', 'string', 'max:255'] : ['required', 'string', 'max:255'],
            'code' => ['sometimes', 'string', 'max:20'],
            'description' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
