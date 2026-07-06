<?php

namespace App\Http\Contracts;

use App\Models\SubjectGroup;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SubjectGroupServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?SubjectGroup;
    public function create(array $data): SubjectGroup;
    public function update(int $id, array $data): SubjectGroup;
    public function delete(int $id): bool;
}
