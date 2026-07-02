<?php

namespace App\Http\Requests\TransportExpense;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransportExpenseRequest extends FormRequest
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
     //   dd(request()->all());

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
            'transport_expense_items'=> ['sometimes','required', 'array'],
            'transport_expense_items.*.expense_head_id'=> ['required', 'exists:expense_heads,id'],
            'transport_expense_items.*.quantity'=> ['required', 'numeric'],
            'transport_expense_items.*.amount'=> ['required', 'numeric'],
            'transport_expense_items.*.total_amount'=> ['required', 'numeric'],

        ];
    }


}
