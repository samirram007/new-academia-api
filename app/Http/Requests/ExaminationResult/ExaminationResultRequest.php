<?php

namespace App\Http\Requests\ExaminationResult;

use Illuminate\Foundation\Http\FormRequest;

class ExaminationResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'examination_scheduled_id' => ['required', 'numeric'],
            'marks' => ['required', 'string'],
            'student_id' => ['required', 'numeric'],
        ];
    }
}
