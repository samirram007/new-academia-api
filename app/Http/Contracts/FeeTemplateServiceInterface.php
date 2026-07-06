<?php

namespace App\Http\Contracts;

use App\Models\FeeTemplate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface FeeTemplateServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?FeeTemplate;
    public function create(array $data): FeeTemplate;
    public function update(int $id, array $data): FeeTemplate;
    public function delete(int $id): bool;
}
