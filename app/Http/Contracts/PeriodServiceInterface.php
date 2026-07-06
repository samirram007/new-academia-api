<?php

namespace App\Http\Contracts;

use App\Models\Period;
use Illuminate\Database\Eloquent\Collection;

interface PeriodServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Period;
    public function create(array $data): Period;
    public function update(int $id, array $data): Period;
    public function delete(int $id): bool;
}
