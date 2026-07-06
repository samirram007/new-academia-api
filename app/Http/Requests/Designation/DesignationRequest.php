<?php

namespace App\Http\Requests\Designation;

use Illuminate\Foundation\Http\FormRequest;

class DesignationRequest extends FormRequest
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
                ? ['sometimes', 'string', 'max:255', 'unique:designations,name,' . $this->route('designation')?->id]
                : ['sometimes', 'string', 'max:255', 'unique:designations,name'],
        ];
    }
}
