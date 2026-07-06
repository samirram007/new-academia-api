<?php

namespace App\Http\Requests\Campus;

use Illuminate\Foundation\Http\FormRequest;

class CampusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $campusId = $isUpdate ? $this->route('campus')?->id : null;

        return [
            'name' => $isUpdate
                ? ['sometimes', 'max:255', 'unique:campuses,name,' . $campusId]
                : ['required', 'max:255', 'unique:campuses,name'],
            'code' => $isUpdate
                ? ['sometimes', 'nullable', 'max:255', 'unique:campuses,code,' . $campusId]
                : ['sometimes', 'nullable', 'max:255', 'unique:campuses,code'],
            'address_id' => ['sometimes', 'nullable', 'numeric'],
            'school_id' => ['sometimes', 'nullable', 'numeric', 'exists:schools,id'],
            'education_board_id' => ['sometimes', 'nullable', 'numeric', 'exists:education_boards,id'],
            'contact_no' => ['sometimes', 'nullable', 'string', 'max:10'],
            'email' => ['sometimes', 'nullable', 'string', 'max:50'],
            'establishment_date' => ['sometimes', 'nullable', 'date'],
            'opening_time' => ['sometimes', 'nullable', 'date_format:H:i:s'],
            'closing_time' => ['sometimes', 'nullable', 'date_format:H:i:s'],
            'logo_image_id' => ['sometimes', 'nullable', 'numeric', 'exists:documents,id'],
        ];
    }
}
