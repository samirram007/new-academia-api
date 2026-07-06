<?php

namespace App\Http\Services;

use App\Http\Contracts\ReleaseTypeServiceInterface;
use App\Models\ReleaseType;
use Illuminate\Database\Eloquent\Collection;

class ReleaseTypeService implements ReleaseTypeServiceInterface
{
    public function getAll(): Collection
    {
        return ReleaseType::all();
    }

    public function getById(int $id): ?ReleaseType
    {
        return ReleaseType::find($id);
    }

    public function create(array $data): ReleaseType
    {
        return ReleaseType::create($data);
    }

    public function update(int $id, array $data): ReleaseType
    {
        $model = ReleaseType::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) ReleaseType::destroy($id);
    }
}
