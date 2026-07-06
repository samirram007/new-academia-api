<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponseTrait;
use App\Traits\HasAdvancedFilter;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\StoreImageFolderMapperRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Http\Facades\DocumentFacade;

class DocumentController extends Controller
{
    use HasAdvancedFilter, ApiResponseTrait;
    public function store(StoreDocumentRequest $request)
    {
        return DocumentFacade::store($request);
    }
    public function update(UpdateDocumentRequest $request, $id)
    {
        return DocumentFacade::updateDocument($request, $id);
    }
    public function delete($id)
    {
        return DocumentFacade::deleteDocument($id);
    }
    public function getFile($id)
    {
        return DocumentFacade::getFile($id);
    }
    public function show($id)
    {
        return DocumentFacade::show($id);
    }
    public function userDocuments(Request $request)
    {
        return DocumentFacade::userDocuments($request);
    }

    public function imageToFolder(StoreImageFolderMapperRequest $request)
    {
        return DocumentFacade::imageToFolder($request);
    }
}
