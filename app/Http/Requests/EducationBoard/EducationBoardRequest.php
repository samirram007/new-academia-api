<?php

namespace App\Http\Requests\EducationBoard;

use Illuminate\Foundation\Http\FormRequest;

class EducationBoardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:education_boards,name'],
            'code' => ['required', 'string', 'max:20', 'unique:education_boards,code'],
            'address_id' => ['sometimes', 'nullable', 'numeric'],
            'contact_no' => ['sometimes', 'string', 'max:10'],
            'email' => ['sometimes', 'nullable', 'string', 'max:50'],
            'description' => ['sometimes', 'nullable', 'string'],
            'website' => ['sometimes', 'nullable', 'string', 'max:50'],
            'establishment_date' => ['sometimes', 'nullable', 'date'],
            'logo_image_id' => ['sometimes', 'nullable', 'numeric', 'exists:documents,id'],
        ];

        if ($isUpdate) {
            $boardId = $this->route('education_board')?->id;
            $rules['name'] = ['sometimes', 'string', 'max:255', 'unique:education_boards,name,' . $boardId];
            $rules['code'] = ['sometimes', 'string', 'max:20', 'unique:education_boards,code,' . $boardId];
        }

        return $rules;
    }
}
