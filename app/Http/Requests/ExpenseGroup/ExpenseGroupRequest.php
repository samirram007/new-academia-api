<?php

namespace App\Http\Requests\ExpenseGroup;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseGroupRequest extends FormRequest
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
                ? ['required', 'string', 'max:255', 'unique:expense_groups,name,' . $this->id]
                : ['required', 'string', 'max:255', 'unique:expense_groups,name'],
        ];
    }
}
