<?php

namespace App\Http\Contracts;

use App\Models\ExaminationType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ExaminationTypeServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?ExaminationType;
    public function create(array $data): ExaminationType;
    public function update(int $id, array $data): ExaminationType;
    public function delete(int $id): bool;
}
