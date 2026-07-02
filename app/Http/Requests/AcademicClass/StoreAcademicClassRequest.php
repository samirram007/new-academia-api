<?php

namespace App\Http\Requests\AcademicClass;

use Illuminate\Foundation\Http\FormRequest;

class StoreAcademicClassRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'campus_id' => 'required|integer|exists:campuses,id',
            'academic_standard_id' => 'sometimes|required|integer|exists:academic_standards,id',
            'capacity' => 'sometimes|required|integer',
        ];
    }
}
