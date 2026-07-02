<?php

namespace App\Http\Requests\TransportExpense;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransportExpenseRequest extends FormRequest
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

            'expense_no'=> ['required','string','max:255'],
            'expense_date'=> ['required', 'date'],
            'user_id' =>  ['sometimes','nullable','numeric', 'exists:users,id'],
            'academic_session_id'=> ['required', 'exists:academic_sessions,id'],
            'campus_id'=> ['required', 'exists:campuses,id'],
            'total_amount'=> ['required', 'numeric'],
            'paid_amount'=> ['sometimes','required', 'numeric'],
            'balance_amount'=> ['sometimes','required', 'numeric'],
            'payment_mode'=> ['sometimes','required','string','max:255'],
            'expense_items'=> ['sometimes','required', 'array'],
            'expense_items.*.expense_head_id'=> ['required', 'exists:expense_heads,id'],
            'expense_items.*.quantity'=> ['required', 'numeric'],
            'expense_items.*.amount'=> ['required', 'numeric'],
            'expense_items.*.total_amount'=> ['required', 'numeric'],

        ];
    }
}
