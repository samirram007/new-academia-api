<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $bookId = $isUpdate ? $this->route('book') : null;

        return [
            'name' => $isUpdate
                ? ['sometimes', 'string', 'max:255', 'unique:boards,name,' . $bookId]
                : ['required', 'string', 'max:255', 'unique:boards,name'],
            'code' => $isUpdate
                ? ['sometimes', 'string', 'max:20', 'unique:books,code,' . $bookId]
                : ['sometimes', 'string', 'max:20', 'unique:books,code'],
            'description' => ['sometimes', 'string'],
            'academic_standard_id' => ['sometimes', 'numeric', 'exists:academic_standards,id'],
            'subject_id' => ['sometimes', 'numeric', 'exists:subjects,id'],
            'publication_year' => ['sometimes', 'numeric'],
            'page_count' => ['sometimes', 'numeric'],
            'price' => ['sometimes', 'numeric'],
            'published_at' => ['sometimes', 'datetime'],
            'publisher' => ['sometimes', 'string'],
            'author' => ['sometimes', 'string'],
            'illustrator' => ['sometimes', 'string'],
            'translator' => ['sometimes', 'string'],
        ];
    }
}
