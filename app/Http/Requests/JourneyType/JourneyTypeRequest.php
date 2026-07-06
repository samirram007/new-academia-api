<?php

namespace App\Http\Requests\JourneyType;

use Illuminate\Foundation\Http\FormRequest;

class JourneyTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name' => $isUpdate ? ['sometimes', 'required', 'string', 'max:255'] : ['required', 'string', 'max:255'],
        ];
    }
}
