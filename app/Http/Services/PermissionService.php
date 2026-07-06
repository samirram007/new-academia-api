<?php

namespace App\Http\Services;

use App\Http\Contracts\PermissionServiceInterface;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

class PermissionService implements PermissionServiceInterface
{
    public function getAll(): Collection
    {
        return Permission::all();
    }

    public function getById(int $id): ?Permission
    {
        return Permission::find($id);
    }

    public function create(array $data): Permission
    {
        return Permission::create($data);
    }

    public function update(int $id, array $data): Permission
    {
        $model = Permission::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Permission::destroy($id);
    }
}
