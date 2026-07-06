<?php

namespace App\Http\Contracts;

use App\Models\StudentSession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface StudentSessionServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?StudentSession;
    public function create(array $data): StudentSession;
    public function update(int $id, array $data): StudentSession;
    public function delete(int $id): bool;
}
