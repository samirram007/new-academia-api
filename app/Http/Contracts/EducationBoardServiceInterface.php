<?php

namespace App\Http\Contracts;

use App\Models\EducationBoard;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface EducationBoardServiceInterface
{
    public function getResource(): array;
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?EducationBoard;
    public function create(array $data): EducationBoard;
    public function update(int $id, array $data): EducationBoard;
    public function delete(int $id): bool;
}
