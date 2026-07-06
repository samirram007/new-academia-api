<?php

namespace App\Http\Contracts;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BookServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Book;
    public function create(array $data): Book;
    public function update(int $id, array $data): Book;
    public function delete(int $id): bool;
}
