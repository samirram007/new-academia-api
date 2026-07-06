<?php

namespace App\Http\Contracts;

use App\Models\JourneyType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface JourneyTypeServiceInterface
{
    public function getAll(Request $request): LengthAwarePaginator|Collection;
    public function getById(int $id): ?JourneyType;
    public function create(array $data): JourneyType;
    public function update(int $id, array $data): JourneyType;
    public function delete(int $id): bool;
}
