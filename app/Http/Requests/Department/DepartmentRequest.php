<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
                ? ['sometimes', 'string', 'max:255', 'unique:departments,name,' . $this->route('department')?->id]
                : ['required', 'string', 'max:255', 'unique:departments,name'],
        ];
    }
}
