<?php

namespace App\Http\Contracts;

use App\Models\FeeTemplateItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface FeeTemplateItemServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?FeeTemplateItem;
    public function create(array $data): FeeTemplateItem;
    public function update(int $id, array $data): FeeTemplateItem;
    public function delete(int $id): bool;
}
