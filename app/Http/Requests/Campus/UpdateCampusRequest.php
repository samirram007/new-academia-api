<?php

namespace App\Http\Requests\Campus;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCampusRequest extends FormRequest
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
            'name' => ['sometimes', 'max:255', 'unique:campuses,name,' . $this->route('campus')->id],
            'code' => ['sometimes', 'nullable', 'max:255', 'unique:campuses,code,' . $this->route('campus')->id],
            'address_id' => ['sometimes', 'nullable', 'numeric', 'exists:addresses,id'],
            'school_id' => ['sometimes', 'nullable', 'numeric', 'exists:schools,id'],
            'education_board_id' => ['sometimes', 'nullable', 'numeric', 'exists:education_boards,id'],
            'contact_no' => ['sometimes', 'nullable', 'string', 'max:10'],
            'email' => ['sometimes', 'nullable', 'string', 'max:50'],
            'establishment_date' => ['sometimes', 'nullable', 'date'],
            'opening_time' => ['sometimes', 'nullable', 'date_format:H:i:s'],
            'closing_time' => ['sometimes', 'nullable', 'date_format:H:i:s'],
            'logo_image_id' => ['sometimes', 'numeric', 'exists:documents,id'],
        ];
    }
}
