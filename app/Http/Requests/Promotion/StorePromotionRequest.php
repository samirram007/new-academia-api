<?php

namespace App\Http\Requests\Promotion;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
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
            'promotion_no'=> ['sometimes','nullable','string','max:255'],
            'promotion_date'=> ['sometimes','nullable', 'date'],
            'student_id' =>  ['required','numeric', 'exists:users,id'],
            'old_student_session_id' =>  ['required','numeric', 'exists:student_sessions,id'],
            'new_academic_standard_id' =>  ['required','numeric', 'exists:academic_standards,id'],

        ];
    }


}
