<?php

namespace App\Http\Contracts;

use App\Models\BookChapter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BookChapterServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?BookChapter;
    public function create(array $data): BookChapter;
    public function update(int $id, array $data): BookChapter;
    public function delete(int $id): bool;
}
