<?php

namespace App\Http\Contracts;

use App\Models\Promotion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PromotionServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getStudentsForPromotion(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Promotion;
    public function create(array $data): Promotion;
    public function update(int $id, array $data): Promotion;
    public function delete(int $id): bool;
}
