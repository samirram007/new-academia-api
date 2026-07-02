<?php

namespace App\Http\Requests\FeeItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeeItemRequest extends FormRequest
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
            'fee_head_id'=> ['required', 'exists:fee_heads,id'],
            'amount' => ['required', 'numeric'],
            'quantity'=> ['sometimes','required', 'integer'],
            'total_amount'=> ['sometimes','required', 'integer'],
        ];
    }
}
