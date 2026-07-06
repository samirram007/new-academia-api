<?php

namespace App\Http\Requests\FeeReceipt;

use Illuminate\Foundation\Http\FormRequest;

class FeeReceiptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        $rules = [
            'paid_by_user_id' => ['required', 'exists:users,id'],
            'receipt_date' => ['required', 'date'],
            'amount' => ['required', 'numeric'],
            'payment_mode' => ['sometimes', 'required', 'string', 'max:255'],
            'receipt_no' => ['sometimes', 'required', 'string', 'max:255'],
            'receipt_note' => ['sometimes', 'required', 'string'],
            'is_system_receipt' => ['sometimes', 'required', 'boolean'],
            'system_receipt_date' => ['sometimes', 'required', 'date'],
        ];

        if ($isUpdate) {
            $rules['paid_by_user_id'] = ['sometimes', 'required', 'exists:users,id'];
            $rules['receipt_date'] = ['sometimes', 'required', 'date'];
            $rules['amount'] = ['sometimes', 'required', 'numeric'];
        }

        return $rules;
    }
}
