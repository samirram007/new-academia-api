<?php

namespace App\Http\Contracts;

use App\Models\Examination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ExaminationServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Examination;
    public function create(array $data): Examination;
    public function update(int $id, array $data): Examination;
    public function delete(int $id): bool;
}
