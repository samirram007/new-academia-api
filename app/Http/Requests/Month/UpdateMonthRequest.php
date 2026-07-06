<?php

namespace App\Http\Requests\Month;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMonthRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'short_name' => ['sometimes', 'nullable', 'string', 'max:50'],
            'number' => ['sometimes', 'nullable', 'integer'],
            'no_of_days' => ['sometimes', 'nullable', 'integer'],
            'is_february' => ['sometimes', 'nullable', 'boolean'],
        ];
    }
}
