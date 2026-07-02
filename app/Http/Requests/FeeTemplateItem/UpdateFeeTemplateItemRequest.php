<?php

namespace App\Http\Requests\FeeTemplateItem;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFeeTemplateItemRequest extends FormRequest
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
            'name' => ['sometimes','required','string','max:255'],
            'is_active'=>'sometimes|boolean',
            'sort_index'=>'required|integer',
            'fee_template_id'=>'required|exists:fee_templates,id',
            'fee_head_id'=>'required|exists:fee_heads,id',
            'amount'=>'required|numeric',
            'is_customizable'=>'sometimes|required|boolean',
            'keep_periodic_details'=>'sometimes|required|boolean',
        ];
    }
}
