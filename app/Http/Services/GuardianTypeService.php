<?php

namespace App\Http\Services;

use App\Http\Contracts\GuardianTypeServiceInterface;
use App\Models\GuardianType;
use Illuminate\Database\Eloquent\Collection;

class GuardianTypeService implements GuardianTypeServiceInterface
{
    public function getAll(): Collection
    {
        return GuardianType::all();
    }

    public function getById(int $id): ?GuardianType
    {
        return GuardianType::find($id);
    }

    public function create(array $data): GuardianType
    {
        return GuardianType::create($data);
    }

    public function update(int $id, array $data): GuardianType
    {
        $model = GuardianType::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) GuardianType::destroy($id);
    }
}
