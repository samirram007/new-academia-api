<?php

namespace App\Http\Contracts;

use App\Models\BookModule;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BookModuleServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?BookModule;
    public function create(array $data): BookModule;
    public function update(int $id, array $data): BookModule;
    public function delete(int $id): bool;
}
