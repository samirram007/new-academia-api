<?php

namespace App\Http\Contracts;

use App\Models\ExaminationStandard;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ExaminationStandardServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?ExaminationStandard;
    public function create(array $data): ExaminationStandard;
    public function update(int $id, array $data): ExaminationStandard;
    public function delete(int $id): bool;
}
