<?php

namespace App\Http\Requests\Address;

use App\Enums\AddressTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'user_id' => $isUpdate ? 'nullable|numeric|exists:users,id' : 'required|numeric|exists:users,id',
            'address_type' => $isUpdate ? [Rule::in(AddressTypeEnum::cases())] : [new \Illuminate\Validation\Rules\Enum(AddressTypeEnum::class)],
            'address_line_1' => $isUpdate ? 'nullable|string|max:255' : 'required|string|max:255',
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
