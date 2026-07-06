<?php

namespace App\Http\Contracts;

use App\Models\FeeHead;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface FeeHeadServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?FeeHead;
    public function create(array $data): FeeHead;
    public function update(int $id, array $data): FeeHead;
    public function delete(int $id): bool;
}
