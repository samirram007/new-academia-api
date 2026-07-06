<?php

namespace App\Http\Contracts;

use App\Models\DocumentsFolder;
use Illuminate\Database\Eloquent\Collection;

interface DocumentsFolderServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?DocumentsFolder;
    public function create(array $data): DocumentsFolder;
    public function update(int $id, array $data): DocumentsFolder;
    public function delete(int $id): bool;
}
