<?php

namespace App\Http\Contracts;

use App\Models\Document;
use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\Document\DocumentCollection;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Http\Requests\Document\StoreImageFolderMapperRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface DocumentServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Document;
    public function create(array $data): Document;
    public function update(int $id, array $data): Document;
    public function delete(int $id): bool;

    // ─── Controller-facing methods ─────────────────────────────────────

    public function store(StoreDocumentRequest $request): DocumentCollection;
    public function updateDocument(UpdateDocumentRequest $request, int $id): DocumentResource;
    public function deleteDocument(int $id): \Illuminate\Http\JsonResponse;
    public function getFile(int $id): \Illuminate\Http\Response;
    public function show(int $id): DocumentResource;
    public function userDocuments(Request $request): DocumentCollection;
    public function imageToFolder(StoreImageFolderMapperRequest $request): \Illuminate\Http\JsonResponse;
}
