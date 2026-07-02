<?php

namespace App\Http\Requests\ExaminationSchedule;

use Illuminate\Foundation\Http\FormRequest;

class ExaminationScheduleStoreRequest extends FormRequest
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
            'examination_standard_id'=> ['required','numeric'],
            'subject_id'=> ['required','numeric'],
            'examination_date'=> ['required','date'],
            'examination_time'=> ['required','string'],
            'teacher_id'=> ['required','numeric'],
        ];
    }
}
