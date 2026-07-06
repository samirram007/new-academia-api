<?php

namespace App\Http\Requests\BookChapter;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookChapterRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'book_id' => ['sometimes', 'numeric', 'exists:books,id'],
            'code' => ['sometimes', 'string', 'max:20'],
            'description' => ['sometimes', 'string'],
        ];
    }
}
