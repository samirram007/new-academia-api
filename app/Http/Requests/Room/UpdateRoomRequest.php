<?php

namespace App\Http\Requests\Room;

use App\Enums\RoomTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'code' => ['sometimes', 'string','max:20'],
            'capacity' => ['sometimes', 'numeric'],
            'floor_id'=>['sometimes','numeric','exists:floors,id'],
            'is_available'=>['sometimes','boolean'],
            'room_type'=>['sometimes', Rule::in(RoomTypeEnum::cases())]
        ];
    }
}
