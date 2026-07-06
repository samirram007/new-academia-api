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

    $folderId = $this->input('folder');
    $documentId = $this->input('image');

        return [
           'folder' => [
               'required', 'integer', 'exists:documents,id',
               Rule::unique('documents_folders', 'folder_id')
                   ->where(fn ($q) => $q->where('document_id', $documentId)),
           ],
           'image' => [
               'required', 'integer', 'exists:documents,id',
               Rule::unique('documents_folders', 'document_id')
                   ->where(fn ($q) => $q->where('folder_id', $folderId)),
           ],
        ];
    }
}
