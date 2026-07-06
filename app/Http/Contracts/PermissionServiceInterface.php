<?php

namespace App\Http\Contracts;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

interface PermissionServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Permission;
    public function create(array $data): Permission;
    public function update(int $id, array $data): Permission;
    public function delete(int $id): bool;
}
