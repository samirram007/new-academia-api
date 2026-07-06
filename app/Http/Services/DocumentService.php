<?php

namespace App\Http\Services;

use App\Http\Contracts\DocumentServiceInterface;
use App\Models\Document;
use App\Models\DocumentsFolder;
use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\Document\DocumentCollection;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Http\Requests\Document\StoreImageFolderMapperRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentService implements DocumentServiceInterface
{
    public function getAll(): Collection
    {
        return Document::all();
    }

    public function getById(int $id): ?Document
    {
        return Document::find($id);
    }

    public function create(array $data): Document
    {
        return Document::create($data);
    }

    public function update(int $id, array $data): Document
    {
        $model = Document::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Document::destroy($id);
    }

    // ─── Additional methods used by DocumentController ───────────────────

    public function store(StoreDocumentRequest $request): DocumentCollection
    {
        $files = $request->file('files') ?? [];
        $userId = Auth::user()->id;
        $name = $request->input('name');
        $documentType = $request->input('document_type');

        DB::transaction(function () use ($files, $userId, $name, $documentType) {
            // If no actual files uploaded (e.g., folder creation), create a single placeholder
            if (empty($files)) {
                $document = Document::create([
                    'user_id' => $userId,
                    'document_type' => $documentType ?? 'folder',
                    'name' => $name ?? 'New Folder',
                    'path' => '',
                    'original_name' => $name ?? 'New Folder',
                    'extension' => '',
                    'mime_type' => '',
                    'size' => 0,
                ]);
                return;
            }

            $mimeToTypeMap = [
                'image/jpeg' => 'image',
                'image/png' => 'image',
                'image/avif' => 'image',
                'image/gif' => 'image',
                'image/webp' => 'image',
                'application/pdf' => 'pdf',
            ];

            foreach ($files as $file) {
                $mimeType = $file->getMimeType();
                $docType = $mimeToTypeMap[$mimeType] ?? 'doc';
                $uuid = (string) Str::uuid();
                $extension = $file->getClientOriginalExtension();
                $fileName = $uuid . '.' . $extension;
                $path = $file->storeAs('documents/' . $userId . '/' . $extension, $fileName, 'public');

                Document::create([
                    'user_id' => $userId,
                    'document_type' => $docType,
                    'path' => $path,
                    'name' => $fileName,
                    'original_name' => $file->getClientOriginalName(),
                    'extension' => $extension,
                    'mime_type' => $mimeType,
                    'size' => $file->getSize(),
                ]);
            }
        });

        return new DocumentCollection(Document::where('user_id', $userId)->get());
    }

    public function updateDocument(UpdateDocumentRequest $request, int $id): DocumentResource
    {
        $document = Document::findOrFail($id);
        $validatedData = $request->validated();
        $document->update($validatedData);

        return new DocumentResource($document);
    }

    public function deleteDocument(int $id): JsonResponse
    {
        $document = Document::find($id);
        if (!$document) {
            return response()->json([
                'data' => [],
                'success' => false,
                'code' => 404,
                'message' => 'Document not found',
            ], 404);
        }

        $path = $document->path;
        $document->delete();

        if ($path) {
            Storage::delete('public/' . $path);
        }

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Document deleted successfully',
        ], 200);
    }

    public function getFile(int $id): Response
    {
        $document = Document::findOrFail($id);
        $content = Storage::get('public/' . $document->path);
        $response = Response::make($content, 200);
        $response->header('Content-Type', $document->mime_type);
        $response->header('Content-Disposition', 'attachment; filename=' . $document->original_name);

        return $response;
    }

    public function show(int $id): DocumentResource
    {
        $document = Document::findOrFail($id);
        return new DocumentResource($document);
    }

    public function userDocuments(Request $request): DocumentCollection
    {
        $query = Document::with(['documents', 'folders'])
            ->where('user_id', Auth::user()->id);

        if ($request->has('type')) {
            $query->where('document_type', $request->type);
        }

        if ($request->has('tags')) {
            $query->where('tags', $request->tags);
        }

        $documents = $query->orderByRaw('document_type = "folder" DESC, original_name ASC, updated_at DESC')->get();

        return new DocumentCollection($documents);
    }

    public function imageToFolder(StoreImageFolderMapperRequest $request): JsonResponse
    {
        $documentFolder = new DocumentsFolder();
        $documentFolder->document_id = $request->input('image');
        $documentFolder->folder_id = $request->input('folder');
        $documentFolder->save();

        return response()->json([
            'success' => true,
            'message' => 'Document folder mapped successfully',
        ], 201);
    }
}
