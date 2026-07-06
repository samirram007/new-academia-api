<?php

namespace App\Http\Services;

use App\Http\Contracts\DocumentsFolderServiceInterface;
use App\Models\DocumentsFolder;
use Illuminate\Database\Eloquent\Collection;

class DocumentsFolderService implements DocumentsFolderServiceInterface
{
    public function getAll(): Collection
    {
        return DocumentsFolder::all();
    }

    public function getById(int $id): ?DocumentsFolder
    {
        return DocumentsFolder::find($id);
    }

    public function create(array $data): DocumentsFolder
    {
        return DocumentsFolder::create($data);
    }

    public function update(int $id, array $data): DocumentsFolder
    {
        $model = DocumentsFolder::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) DocumentsFolder::destroy($id);
    }
}
