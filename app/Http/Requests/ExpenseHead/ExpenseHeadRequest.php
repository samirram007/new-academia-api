<?php

namespace App\Http\Requests\ExpenseHead;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpenseHeadRequest extends FormRequest
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
                ? ['required', 'string', 'max:255', Rule::unique('expense_heads', 'name')->ignore($this->id)]
                : ['required', 'string', 'max:255', 'unique:expense_heads,name'],
            'expense_group_id' => ['sometimes', 'nullable', 'numeric'],
        ];
    }
}
