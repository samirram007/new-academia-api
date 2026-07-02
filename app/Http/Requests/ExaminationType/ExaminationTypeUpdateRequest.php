<?php

namespace App\Http\Requests\ExaminationType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExaminationTypeUpdateRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('examination_types', 'name')->ignore($this->route('examination_type'))
            ],

            'is_promotional_exam' => ['required', 'boolean']
        ];
    }
}
