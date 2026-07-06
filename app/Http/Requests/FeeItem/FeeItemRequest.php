<?php

namespace App\Http\Requests\FeeItem;

use Illuminate\Foundation\Http\FormRequest;

class FeeItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fee_id' => ['required', 'exists:fees,id'],
            'fee_head_id' => ['required', 'exists:fee_heads,id'],
            'amount' => ['required', 'numeric'],
            'quantity' => ['sometimes', 'required', 'integer'],
            'total_amount' => ['sometimes', 'required', 'integer'],
        ];
    }
}
