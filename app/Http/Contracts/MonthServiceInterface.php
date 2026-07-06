<?php

namespace App\Http\Contracts;

use App\Models\Month;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface MonthServiceInterface
{
    public function getAll(Request $request): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Month;
    public function create(array $data): Month;
    public function update(int $id, array $data): Month;
    public function delete(int $id): bool;
}
