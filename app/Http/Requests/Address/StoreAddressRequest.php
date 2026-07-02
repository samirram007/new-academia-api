<?php

namespace App\Http\Requests\Address;

use App\Enums\AddressTypeEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'user_id' => 'required|numeric|exists:users,id',
            'address_type' => new Enum(AddressTypeEnum::class),
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'post_office' => 'nullable|string|max:255',
            'rail_station' => 'nullable|string|max:255',
            'police_station' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'state_id' => 'nullable|numeric|exists:states,id',
            'country_id' => 'nullable|numeric|exists:countries,id',
            'pincode' => 'nullable|string|min:6|max:10',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ];
    }
}