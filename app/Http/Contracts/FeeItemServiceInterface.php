<?php

namespace App\Http\Contracts;

use App\Models\FeeItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface FeeItemServiceInterface
{
    public function getAll(Request $request): LengthAwarePaginator|Collection;
    public function getById(int $id): ?FeeItem;
    public function create(array $data): FeeItem;
    public function update(int $id, array $data): FeeItem;
    public function delete(int $id): bool;
}
