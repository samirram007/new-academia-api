<?php

namespace App\Http\Requests\Building;

use Illuminate\Foundation\Http\FormRequest;

class BuildingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name' => $isUpdate ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'code' => 'sometimes|string|max:255',
            'campus_id' => $isUpdate ? 'sometimes|required|numeric|exists:campuses,id' : 'required|numeric|exists:campuses,id',
            'capacity' => 'sometimes|required|numeric',
        ];
    }
}
