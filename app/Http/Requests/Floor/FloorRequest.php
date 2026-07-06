<?php

namespace App\Http\Requests\Floor;

use Illuminate\Foundation\Http\FormRequest;

class FloorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name' => $isUpdate ? ['sometimes', 'string', 'max:255'] : ['required', 'string', 'max:255'],
            'code' => ['sometimes', 'string', 'max:20'],
            'capacity' => ['sometimes', 'numeric'],
            'building_id' => ['sometimes', 'numeric', 'exists:buildings,id'],
        ];
    }
}
