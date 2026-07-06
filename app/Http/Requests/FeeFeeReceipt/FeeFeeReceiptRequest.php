<?php

namespace App\Http\Requests\FeeFeeReceipt;

use Illuminate\Foundation\Http\FormRequest;

class FeeFeeReceiptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fee_id' => ['required', 'exists:fees,id'],
            'fee_receipt_id' => ['required', 'exists:fee_receipts,id'],
        ];
    }
}
