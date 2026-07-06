<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        if ($isUpdate) {
            return [
                'files.*' => 'sometimes|required|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
                'original_name' => 'sometimes|required',
            ];
        }

        return [
            'files.*' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:4196',
        ];
    }

    public function validatedWithFiles(): array
    {
        return array_merge(parent::validated(), [
            'file' => $this->file('file'),
        ]);
    }
}
