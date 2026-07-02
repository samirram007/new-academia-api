<?php

namespace App\Http\Requests\Document;

use App\Models\DocumentsFolder;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueDocumentFolderCombination;

class StoreImageFolderMapperRequest extends FormRequest
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
    public function rules()
    {

    $uniqueRule = Rule::unique('documents_folders')->where(function ($query) {
        // Use the values from the request to check for uniqueness
        return $query->where('folder_id', $this->input('folder_id'))
                     ->where('document_id', $this->input('document_id'));
    });

        return [
           "folder_id" => ["required", "integer", "exists:documents,id",$uniqueRule],
           "document_id" => ["required", "integer", "exists:documents,id", $uniqueRule],
        ];
    }
}
