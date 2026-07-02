<?php

namespace App\Http\Controllers\Api;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Services\DocumentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\StoreImageFolderMapperRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;

class DocumentController extends Controller
{
    protected $documentService;
    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function store(StoreDocumentRequest $request)
    {
        return $this->documentService->store($request);

    }
    public function update(UpdateDocumentRequest $request ,$id)
    {

        return $this->documentService->update($request,$id);

    }
    public function delete($id)
    {
        return $this->documentService->delete($id);

    }
    public function getFile($id)
    {
        return $this->documentService->getFile($id);

    }
    public function show($id)
    {
        return $this->documentService->getFile($id);

    }
    public function userDocuments(Request $request)
    {
        return $this->documentService->userDocuments($request);

    }

    public function imageToFolder(StoreImageFolderMapperRequest $request)
    {
        return $this->documentService->imageToFolder($request);
    }
}
