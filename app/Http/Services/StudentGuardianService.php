<?php

namespace App\Http\Services;

use App\Http\Contracts\StudentGuardianServiceInterface;
use App\Models\StudentGuardian;
use Illuminate\Database\Eloquent\Collection;

class StudentGuardianService implements StudentGuardianServiceInterface
{
    public function getAll(): Collection
    {
        return StudentGuardian::all();
    }

    public function getById(int $id): ?StudentGuardian
    {
        return StudentGuardian::find($id);
    }

    public function create(array $data): StudentGuardian
    {
        return StudentGuardian::create($data);
    }

    public function update(int $id, array $data): StudentGuardian
    {
        $model = StudentGuardian::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) StudentGuardian::destroy($id);
    }
}
