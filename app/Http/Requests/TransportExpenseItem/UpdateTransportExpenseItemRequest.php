<?php

namespace App\Http\Requests\TransportExpenseItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransportExpenseItemRequest extends FormRequest
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
            'transport_expense_id' => ['required', 'exists:transport_expenses,id'],
            'expense_head_id'=> ['required', 'exists:expense_heads,id'],
            'amount' => ['required', 'numeric'],
            'quantity'=> ['sometimes','required', 'integer'],
            'total_amount'=> ['sometimes','required', 'integer'],
        ];
    }
}
