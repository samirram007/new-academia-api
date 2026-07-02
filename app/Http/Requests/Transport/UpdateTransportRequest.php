<?php

namespace App\Http\Requests\Transport;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransportRequest extends FormRequest
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
        return [
            'name' => ['sometimes','required','string','max:255'],
            'registration_no' => ['sometimes','string','max:25'],
            'registration_date'=>['sometimes','nullable','date'],
            'registration_valid_date'=>['sometimes','nullable','date'],
            'chasis_no' => ['sometimes','nullable','string','max:50'],
            'engine_no' => ['sometimes','nullable','string','max:50'],
            'color' => ['sometimes','nullable','string','max:25'],
            'capacity' => ['sometimes','nullable','numeric'],
            'transport_type_id' => ['required','exists:transport_types,id'],
        ];
    }
}
