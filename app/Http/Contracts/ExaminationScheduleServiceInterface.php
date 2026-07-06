<?php

namespace App\Http\Contracts;

use App\Models\ExaminationSchedule;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ExaminationScheduleServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?ExaminationSchedule;
    public function create(array $data): ExaminationSchedule;
    public function update(int $id, array $data): ExaminationSchedule;
    public function delete(int $id): bool;
}
