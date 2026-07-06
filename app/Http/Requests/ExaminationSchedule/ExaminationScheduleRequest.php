<?php

namespace App\Http\Requests\ExaminationSchedule;

use Illuminate\Foundation\Http\FormRequest;

class ExaminationScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'examination_standard_id' => $isUpdate ? ['string', 'required'] : ['required', 'numeric'],
            'subject_id' => $isUpdate ? ['string', 'required'] : ['required', 'numeric'],
            'examination_date' => ['required', 'date'],
            'examination_time' => ['required', 'string'],
            'teacher_id' => ['required', 'numeric'],
        ];
    }
}
