<?php

namespace App\Http\Requests\ExpenseItem;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'expense_id' => ['required', 'exists:expenses,id'],
            'expense_head_id'=> ['required', 'exists:expense_heads,id'],
            'amount' => ['required', 'numeric'],
            'quantity'=> ['sometimes','required', 'integer'],
            'total_amount'=> ['sometimes','required', 'integer'],
        ];
    }
}
