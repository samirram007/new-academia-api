<?php

namespace App\Http\Contracts;

use App\Models\Address;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AddressServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Address;
    public function create(array $data): Address;
    public function update(int $id, array $data): Address;
    public function delete(int $id): bool;
}
