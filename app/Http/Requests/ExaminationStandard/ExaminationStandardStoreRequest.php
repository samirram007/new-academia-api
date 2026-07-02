<?php

namespace App\Http\Requests\ExaminationStandard;

use Illuminate\Foundation\Http\FormRequest;

class ExaminationStandardStoreRequest extends FormRequest
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
            'academic_standard_id'=> ['required','numeric'],
            'examination_id'=>['required','numeric']
        ];
    }
}
