<?php

namespace App\Http\Requests\Subject;

use App\Enums\SubjectTypeEnum;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubjectRequest extends FormRequest
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
            'name' => ['required','string','max:255'],
            'code' => ['sometimes','string','max:20'],
            'description'=>['sometimes','nullable','string'],
            'subject_type' =>  ['required',Rule::in(SubjectTypeEnum::cases())],
            'subject_group_id' => ['required','exists:subject_groups,id'],
            'academic_standard_id' => ['required','exists:academic_standards,id'],
            'logo_image_id' => ['sometimes','nullable','exists:documents,id'],
            'is_active' => ['sometimes','boolean'],

        ];
    }
}
