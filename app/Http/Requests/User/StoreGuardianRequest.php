<?php

namespace App\Http\Requests\User;

use App\Enums\CasteEnum;
use App\Enums\GenderEnum;
use App\Enums\GuardianTypeEnum;
use App\Enums\LanguageEnum;
use App\Enums\NationalityEnum;
use App\Enums\ReligionEnum;
use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use App\Exceptions\GeneralJsonException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGuardianRequest extends FormRequest
{
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
        $validator= [
            'name' => 'required|string|max:255',
            'user_type'=> ['required',Rule::in(UserTypeEnum::cases())],
            'username'=>'sometimes|string|max:10|unique:users,username',
            'student_id'=>'required|exists:users,id',
            'code'=>'sometimes|string|max:50|unique:users,code',
            'email' => 'sometimes|required|email',
            'contact_no' => 'sometimes|required|max:10',
            // 'password' => 'required', 'confirmed', Password::min(8)->letters()->symbols(),
            'status'=>['sometimes','required',Rule::in(UserStatusEnum::cases())],

            'nationality'=>['sometimes','required',Rule::in(NationalityEnum::cases())],
            'language'=>['sometimes','required',Rule::in(LanguageEnum::cases())],
            'religion'=>['sometimes','required',Rule::in(ReligionEnum::cases())],
            'caste'=>['sometimes','required',Rule::in(CasteEnum::cases())],
            'guardian_type'=>['required',Rule::in(GuardianTypeEnum::cases())],
            'designation_id'=>'sometimes|required|exists:designations,id',
            'department_id'=>'sometimes|required|exists:departments,id',
            'gender'=>['sometimes','required',Rule::in(GenderEnum::cases())],
            'doj'=>'sometimes|required|date',
            'dob'=>'sometimes|required|date',
            'aadhaar_no'=>'sometimes|required|string|max:20',
            'pan_no'=>'sometimes|required|string|max:20',
            'passport_no'=>'sometimes|required|string|max:50',
            'profile_document_id'=>'sometimes|required|exists:documents,id',
            'bank_name'=>'sometimes|required|string|max:100',
            'account_holder_name'=>'sometimes|required|string|max:100',
            'bank_account_no'=>'sometimes|required|string|max:20',
            'bank_ifsc'=>'sometimes|required|string|max:20',
            'bank_branch'=>'sometimes|required|string|max:100',
            'admission_no'=>'sometimes|nullable',
            'admission_date'=>'sometimes|required|date',
            'occupation'=>'sometimes|nullable',
            'education'=>'sometimes|nullable',
            'earnings'=>'sometimes|nullable',
        ];

       throw_if(!$validator,GeneralJsonException::class);
       return $validator;
    }

    // on not validate
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'user_type.required' => 'User type is required',
            'guardian_type.required' => 'Guardian type is required',
            'student_id.required' => 'Student is required',
            'username.required' => 'Username is required',
            'email.required' => 'Email is required',
            'password.required' => '<PASSWORD>',
        ];
    }

}