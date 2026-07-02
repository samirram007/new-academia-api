<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'name'=>['sometimes','string','max:255','unique:boards,name,'.$this->id],
            'code' => ['sometimes','string','max:20','unique:books,code,'.$this->id],
            'description'=>['sometimes','string'],
            'academic_standard_id'=>['sometimes','numeric','exists:academic_standards,id'],
            'subject_id'=>['sometimes','numeric','exists:subjects,id'],
            'publication_year'=>['sometimes','numeric'],
            'page_count'=>['sometimes','numeric'],
            'price'=>['sometimes','numeric'],
            'published_at'=>['sometimes','datetime'],
            'publisher'=>['sometimes','string'],
            'author'=>['sometimes','string'],
            'illustrator'=>['sometimes','string'],
            'translator'=>['sometimes','string'],
        ];
    }
}
