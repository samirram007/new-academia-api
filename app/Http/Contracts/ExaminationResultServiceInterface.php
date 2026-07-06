<?php

namespace App\Http\Contracts;

use App\Models\ExaminationResult;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ExaminationResultServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?ExaminationResult;
    public function create(array $data): ExaminationResult;
    public function update(int $id, array $data): ExaminationResult;
    public function delete(int $id): bool;
}
