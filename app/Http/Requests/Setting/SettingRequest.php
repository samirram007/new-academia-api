<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'key' => $isUpdate ? ['sometimes', 'required', 'string', 'max:255'] : ['required', 'string', 'max:255'],
            'value' => ['nullable', 'string'],
        ];
    }
}
