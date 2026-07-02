<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
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
    public function rules()
    {
        return [
            'files.*' => 'sometimes|required|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'original_name'=>'sometimes|required',
            // 'file' => 'required|file', // Ensure it's a file
            // Add other validation rules for additional fields if needed
        ];
    }

    public function validatedWithFiles()
    {
        return array_merge(parent::validated(), [
            'file' => $this->file('file'), // Include the file in validated data
        ]);
    }
}
