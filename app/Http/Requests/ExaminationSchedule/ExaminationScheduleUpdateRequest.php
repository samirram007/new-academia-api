<?php

namespace App\Http\Requests\ExaminationSchedule;

use Illuminate\Foundation\Http\FormRequest;

class ExaminationScheduleUpdateRequest extends FormRequest
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
            'examination_standard_id'=> ['string','required'],
            'subject_id'=> ['string','required'],
            'examination_date'=> ['required','date'],
            'examination_time'=> ['required','string'],
            'teacher_id'=> ['required','numeric'],
        ];
    }
}
