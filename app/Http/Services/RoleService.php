<?php

namespace App\Http\Services;

use App\Http\Contracts\RoleServiceInterface;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleService implements RoleServiceInterface
{
    public function getAll(): Collection
    {
        return Role::all();
    }

    public function getById(int $id): ?Role
    {
        return Role::find($id);
    }

    public function create(array $data): Role
    {
        return Role::create($data);
    }

    public function update(int $id, array $data): Role
    {
        $model = Role::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Role::destroy($id);
    }
}
