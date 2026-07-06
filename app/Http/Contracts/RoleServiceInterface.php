<?php

namespace App\Http\Contracts;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

interface RoleServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Role;
    public function create(array $data): Role;
    public function update(int $id, array $data): Role;
    public function delete(int $id): bool;
}
