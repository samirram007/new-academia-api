<?php

namespace App\Http\Requests\SchoolType;

use Illuminate\Foundation\Http\FormRequest;

class SchoolTypeRequest extends FormRequest
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
                ? ['required', 'max:255', 'unique:school_types,name,' . $this->id]
                : ['required', 'max:255', 'unique:school_types,name'],
        ];
    }
}
