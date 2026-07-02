<?php

namespace App\Http\Requests\TransportUser;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransportUserRequest extends FormRequest
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
            'join_date' => ['sometimes','nullable','date'],
            'is_free' => ['sometimes','nullable','boolean'],
            'is_active' => ['sometimes','nullable','boolean'],
            'monthly_charge' => ['sometimes','nullable','numeric'],
            'transport_id' => ['required','exists:transports,id'],
            'journey_type_id' => ['required','exists:journey_types,id'],
            'user_id' => ['required','exists:users,id'],
        ];
    }
}
