<?php

namespace App\Http\Requests\Room;

use App\Enums\RoomTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'floor_id' => ['sometimes', 'numeric', 'exists:floors,id'],
            'is_available' => ['sometimes', 'boolean'],
            'room_type' => ['sometimes', Rule::in(RoomTypeEnum::cases())],
        ];
    }
}
