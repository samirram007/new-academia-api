<?php

namespace App\Http\Requests\ExpenseItem;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'expense_id' => ['required', 'exists:expenses,id'],
            'expense_head_id' => ['required', 'exists:expense_heads,id'],
            'amount' => ['required', 'numeric'],
            'quantity' => ['sometimes', 'required', 'integer'],
            'total_amount' => ['sometimes', 'required', 'integer'],
        ];
    }
}
