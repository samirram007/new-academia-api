<?php

namespace App\Http\Contracts;

use App\Models\School;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SchoolServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?School;
    public function create(array $data): School;
    public function update(int $id, array $data): School;
    public function delete(int $id): bool;
}
