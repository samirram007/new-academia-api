<?php

namespace App\Http\Requests\Teacher;

use App\Enums\CasteEnum;
use App\Enums\GenderEnum;
use App\Enums\LanguageEnum;
use App\Enums\NationalityEnum;
use App\Enums\ReligionEnum;
use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeacherRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'user_type' => ['required', Rule::in(UserTypeEnum::cases())],
            'username' => ['sometimes', 'string', 'max:10', 'unique:users,username'],
            'code' => ['sometimes', 'string', 'max:50', 'unique:users,code'],
            'email' => ['sometimes', 'required', 'email'],
            'contact_no' => ['sometimes', 'required', 'max:10'],
            'status' => ['sometimes', 'required', Rule::in(UserStatusEnum::cases())],
            'emergency_contact_name' => ['sometimes', 'required', 'string', 'max:100'],
            'emergency_contact_no' => ['sometimes', 'required', 'string', 'max:10'],
            'birth_mark' => ['sometimes', 'required', 'string', 'max:100'],
            'medical_conditions' => ['sometimes', 'required', 'string', 'max:200'],
            'allergies' => ['sometimes', 'required', 'string', 'max:200'],
            'nationality' => ['sometimes', 'required', Rule::in(NationalityEnum::cases())],
            'language' => ['sometimes', 'required', Rule::in(LanguageEnum::cases())],
            'religion' => ['sometimes', 'required', Rule::in(ReligionEnum::cases())],
            'caste' => ['sometimes', 'required', Rule::in(CasteEnum::cases())],
            'designation_id' => ['sometimes', 'required', 'exists:designations,id'],
            'department_id' => ['sometimes', 'required', 'exists:departments,id'],
            'gender' => ['sometimes', 'required', Rule::in(GenderEnum::cases())],
            'doj' => ['sometimes', 'required', 'date'],
            'dob' => ['sometimes', 'required', 'date'],
            'aadhaar_no' => ['sometimes', 'required', 'string', 'max:20'],
            'pan_no' => ['sometimes', 'required', 'string', 'max:20'],
            'passport_no' => ['sometimes', 'required', 'string', 'max:50'],
            'profile_document_id' => ['sometimes', 'required', 'exists:documents,id'],
            'bank_name' => ['sometimes', 'required', 'string', 'max:100'],
            'account_holder_name' => ['sometimes', 'required', 'string', 'max:100'],
            'bank_account_no' => ['sometimes', 'required', 'string', 'max:20'],
            'bank_ifsc' => ['sometimes', 'required', 'string', 'max:20'],
            'bank_branch' => ['sometimes', 'required', 'string', 'max:100'],
            'admission_no' => ['sometimes', 'nullable'],
            'admission_date' => ['sometimes', 'required', 'date'],
            'campus_id' => ['sometimes', 'nullable', 'exists:campuses,id'],
            'academic_session_id' => ['sometimes', 'nullable', 'exists:academic_sessions,id'],
            'academic_class_id' => ['sometimes', 'nullable', 'exists:academic_classes,id'],
        ];
    }
}
