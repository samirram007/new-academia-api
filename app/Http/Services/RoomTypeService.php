<?php

namespace App\Http\Services;

use App\Http\Contracts\RoomTypeServiceInterface;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Collection;

class RoomTypeService implements RoomTypeServiceInterface
{
    public function getAll(): Collection
    {
        return RoomType::all();
    }

    public function getById(int $id): ?RoomType
    {
        return RoomType::find($id);
    }

    public function create(array $data): RoomType
    {
        return RoomType::create($data);
    }

    public function update(int $id, array $data): RoomType
    {
        $model = RoomType::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) RoomType::destroy($id);
    }
}
