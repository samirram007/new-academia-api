<?php

namespace App\Http\Contracts;

use App\Models\Subject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SubjectServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Subject;
    public function create(array $data): Subject;
    public function update(int $id, array $data): Subject;
    public function delete(int $id): bool;
}
