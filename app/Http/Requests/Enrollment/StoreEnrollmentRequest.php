<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
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
     //   dd(request()->all());

        return [
            'student_id'=> ['required', 'exists:users,id'],
            'academic_session_id'=> ['required', 'exists:academic_sessions,id'],
            'academic_class_id'=> ['required', 'exists:academic_classes,id'],
            'campus_id'=> ['required', 'exists:campuses,id'],
            'section_id'=> ['required', 'exists:sections,id'],
            'admission_no'=> ['sometimes','nullable'],
            'roll_no'=> ['sometimes','nullable'],
            'admission_date'=> ['sometimes','nullable'],
            'status'=> ['sometimes','nullable'],


        ];
    }


}
