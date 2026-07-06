<?php

namespace App\Http\Contracts;

use App\Models\SharedDocument;
use Illuminate\Database\Eloquent\Collection;

interface SharedDocumentServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?SharedDocument;
    public function create(array $data): SharedDocument;
    public function update(int $id, array $data): SharedDocument;
    public function delete(int $id): bool;
}
