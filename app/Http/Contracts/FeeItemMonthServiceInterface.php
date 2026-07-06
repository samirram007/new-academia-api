<?php

namespace App\Http\Contracts;

use App\Models\FeeItemMonth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface FeeItemMonthServiceInterface
{
    public function getAll(Request $request): LengthAwarePaginator|Collection;
    public function getById(int $id): ?FeeItemMonth;
    public function create(array $data): FeeItemMonth;
    public function update(int $id, array $data): FeeItemMonth;
    public function delete(int $id): bool;
}
