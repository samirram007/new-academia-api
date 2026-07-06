<?php

namespace App\Http\Contracts;

use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface RoomServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Room;
    public function create(array $data): Room;
    public function update(int $id, array $data): Room;
    public function delete(int $id): bool;
}
