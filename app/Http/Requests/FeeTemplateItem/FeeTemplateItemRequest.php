<?php

namespace App\Http\Requests\FeeTemplateItem;

use Illuminate\Foundation\Http\FormRequest;

class FeeTemplateItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name' => $isUpdate ? ['sometimes', 'required', 'string', 'max:255'] : ['required', 'string', 'max:255'],
            'is_active' => 'sometimes|boolean',
            'sort_index' => ['required', 'integer'],
            'fee_template_id' => ['required', 'exists:fee_templates,id'],
            'fee_head_id' => ['required', 'exists:fee_heads,id'],
            'amount' => ['required', 'numeric'],
            'is_customizable' => 'sometimes|required|boolean',
            'keep_periodic_details' => 'sometimes|required|boolean',
        ];
    }
}
