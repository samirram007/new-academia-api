<?php

namespace App\Http\Requests\FeeHead;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeeHeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name' => $isUpdate
                ? ['required', 'string', 'max:255', Rule::unique('fee_heads', 'name')->ignore($this->id)]
                : ['required', 'string', 'max:255', 'unique:fee_heads,name'],
            'income_group_id' => ['sometimes', 'nullable', 'numeric'],
        ];
    }
}
