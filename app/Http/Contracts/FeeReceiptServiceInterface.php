<?php

namespace App\Http\Contracts;

use App\Models\FeeReceipt;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface FeeReceiptServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?FeeReceipt;
    public function create(array $data): FeeReceipt;
    public function update(int $id, array $data): FeeReceipt;
    public function delete(int $id): bool;
}
