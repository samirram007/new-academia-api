<?php

namespace App\Http\Requests\FeeReceipt;

use Illuminate\Foundation\Http\FormRequest;

class UpadteFeeReceiptRequest extends FormRequest
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
            'paid_by_user_id'=> ['sometimes','required', 'exists:users,id'],
            'receipt_date'=> ['sometimes','required', 'date'],
            'amount'=> ['sometimes','required', 'numeric'],
            'payment_mode'=> ['sometimes','required','string','max:255'],
            'receipt_no'=> ['sometimes','required','string','max:255'],
            'receipt_note'=>['sometimes','required','string'],
            'is_system_receipt'=>['sometimes','required','boolean'],
            'system_receipt_date'=>['sometimes','required','date'],
        ];
    }
}
