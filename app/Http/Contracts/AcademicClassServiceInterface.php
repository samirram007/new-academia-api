<?php

namespace App\Http\Contracts;

use App\Models\AcademicClass;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AcademicClassServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?AcademicClass;
    public function create(array $data): AcademicClass;
    public function update(int $id, array $data): AcademicClass;
    public function delete(int $id): bool;
}
