<?php

namespace App\Http\Contracts;

use App\Models\Section;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SectionServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Section;
    public function create(array $data): Section;
    public function update(int $id, array $data): Section;
    public function delete(int $id): bool;
}
