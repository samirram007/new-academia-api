<?php

namespace App\Http\Requests\EducationBoard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEducationBoardRequest extends FormRequest
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
        //dd($this->route('education_board')->id);
        return [
            'name' => ['sometimes', 'string', 'max:255',
                'unique:education_boards,name,' . $this->route('education_board')->id],
            'code' => ['sometimes', 'string', 'max:20',
                'unique:education_boards,code,' . $this->route('education_board')->id],
            'address_id' => ['sometimes', 'nullable', 'numeric'],
            'contact_no' => ['sometimes', 'nullable', 'string', 'max:10'],
            'email' => ['sometimes', 'nullable', 'string', 'max:50'],
            'description' => ['sometimes', 'nullable', 'string'],
            'website' => ['sometimes', 'nullable', 'string', 'max:50'],
            'establishment_date' => ['sometimes', 'nullable', 'date'],
            'logo_image_id' => ['sometimes', 'nullable', 'numeric', 'exists:documents,id'],
        ];
    }
}
