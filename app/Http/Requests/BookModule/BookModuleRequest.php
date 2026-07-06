<?php

namespace App\Http\Requests\BookModule;

use Illuminate\Foundation\Http\FormRequest;

class BookModuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name' => $isUpdate ? ['sometimes', 'string', 'max:255'] : ['required', 'string', 'max:255', 'unique:boards,name'],
            'code' => ['sometimes', 'string', 'max:20', 'unique:books,code'],
            'description' => ['sometimes', 'string'],
        ];
    }
}
