<?php

namespace App\Http\Contracts;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Collection;

interface RoomTypeServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?RoomType;
    public function create(array $data): RoomType;
    public function update(int $id, array $data): RoomType;
    public function delete(int $id): bool;
}
