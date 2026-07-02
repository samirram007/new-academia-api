<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'unique:schools,name,' . $this->route('school')->id],
            'code' => ['sometimes', 'max:255', 'unique:schools,code,' . $this->route('school')->id],
            'address_id' => ['sometimes', 'numeric'],
            'school_id' => ['sometimes', 'numeric', 'exists:schools,id'],
            'education_board_id' => ['sometimes', 'numeric', 'exists:education_boards,id'],
            'contact_no' => ['sometimes', 'string', 'max:10'],
            'email' => ['sometimes', 'string', 'max:50'],
            'website' => ['sometimes', 'string', 'max:50'],
            'school_type_id' => ['sometimes', 'numeric', 'exists:school_types,id'],
            'establishment_date' => ['sometimes', 'date'],
            'opening_time' => ['sometimes', 'time'],
            'closing_time' => ['sometimes', 'time'],
            'logo_image_id' => ['sometimes', 'numeric', 'exists:documents,id'],
        ];
    }
}
