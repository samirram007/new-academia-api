<?php

namespace App\Http\Requests\IncomeGroup;

use Illuminate\Foundation\Http\FormRequest;

class IncomeGroupRequest extends FormRequest
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
                ? ['required', 'string', 'max:255', 'unique:income_groups,name,' . $this->id]
                : ['required', 'string', 'max:255', 'unique:income_groups,name'],
        ];
    }
}
