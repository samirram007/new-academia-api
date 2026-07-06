<?php

namespace App\Http\Contracts;

use App\Models\ReleaseType;
use Illuminate\Database\Eloquent\Collection;

interface ReleaseTypeServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?ReleaseType;
    public function create(array $data): ReleaseType;
    public function update(int $id, array $data): ReleaseType;
    public function delete(int $id): bool;
}
