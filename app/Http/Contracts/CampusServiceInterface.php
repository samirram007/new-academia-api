<?php

namespace App\Http\Contracts;

use App\Models\Campus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface CampusServiceInterface
{
    public function getAll(Request $request): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Campus;
    public function create(array $data): Campus;
    public function update(int $id, array $data): Campus;
    public function delete(int $id): bool;
}
