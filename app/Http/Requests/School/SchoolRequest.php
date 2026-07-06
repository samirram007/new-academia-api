<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $schoolId = $isUpdate ? $this->route('school')?->id : null;

        return [
            'name' => $isUpdate
                ? ['required', 'max:255', 'unique:schools,name,' . $schoolId]
                : ['required', 'max:255', 'unique:schools,name'],
            'code' => $isUpdate
                ? ['sometimes', 'max:255', 'unique:schools,code,' . $schoolId]
                : ['sometimes', 'max:255', 'unique:schools,code'],
            'address_id' => ['sometimes', 'numeric'],
            'school_id' => ['sometimes', 'numeric', 'exists:schools,id'],
            'education_board_id' => ['sometimes', 'numeric', 'exists:education_boards,id'],
            'contact_no' => ['sometimes', 'string', 'max:10'],
            'email' => ['sometimes', 'string', 'max:50'],
            'website' => ['sometimes', 'string', 'max:50'],
            'school_type_id' => ['sometimes', 'numeric'],
            'establishment_date' => ['sometimes', 'date'],
            'opening_time' => ['sometimes', 'time'],
            'closing_time' => ['sometimes', 'time'],
            'logo_image_id' => ['sometimes', 'numeric', 'exists:documents,id'],
        ];
    }
}
