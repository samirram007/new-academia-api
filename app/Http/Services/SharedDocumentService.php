<?php

namespace App\Http\Services;

use App\Http\Contracts\SharedDocumentServiceInterface;
use App\Models\SharedDocument;
use Illuminate\Database\Eloquent\Collection;

class SharedDocumentService implements SharedDocumentServiceInterface
{
    public function getAll(): Collection
    {
        return SharedDocument::all();
    }

    public function getById(int $id): ?SharedDocument
    {
        return SharedDocument::find($id);
    }

    public function create(array $data): SharedDocument
    {
        return SharedDocument::create($data);
    }

    public function update(int $id, array $data): SharedDocument
    {
        $model = SharedDocument::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) SharedDocument::destroy($id);
    }
}
