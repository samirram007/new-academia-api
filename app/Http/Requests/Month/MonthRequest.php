<?php

namespace App\Http\Requests\Month;

use Illuminate\Foundation\Http\FormRequest;

class MonthRequest extends FormRequest
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
            'short_name' => ['sometimes', 'nullable', 'string', 'max:50'],
            'number' => ['sometimes', 'nullable', 'integer'],
            'no_of_days' => ['sometimes', 'nullable', 'integer'],
            'is_february' => ['sometimes', 'nullable', 'boolean'],
        ];
    }
}
