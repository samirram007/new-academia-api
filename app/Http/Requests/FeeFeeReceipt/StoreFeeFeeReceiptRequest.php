<?php

namespace App\Http\Requests\FeeFeeReceipt;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeeFeeReceiptRequest extends FormRequest
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
            'fee_id' => ['required', 'exists:fees,id'],
            'fee_receipt_id'=> ['required', 'exists:fee_receipts,id'],
        ];
    }
}
