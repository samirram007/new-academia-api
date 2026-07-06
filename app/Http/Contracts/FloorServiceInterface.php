<?php

namespace App\Http\Contracts;

use App\Models\Floor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface FloorServiceInterface
{
    public function getAll(Request $request): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Floor;
    public function create(array $data): Floor;
    public function update(int $id, array $data): Floor;
    public function delete(int $id): bool;
}
