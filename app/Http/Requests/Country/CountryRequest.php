<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name' => $isUpdate
                ? ['sometimes', 'string', 'max:255', 'unique:countries,name,' . $this->route('country')]
                : ['required', 'string', 'max:255', 'unique:countries,name'],
            'country_code' => $isUpdate
                ? ['sometimes', 'string', 'max:5', 'unique:countries,country_code,' . $this->route('country')]
                : ['sometimes', 'string', 'max:5', 'unique:countries,country_code'],
        ];
    }
}
