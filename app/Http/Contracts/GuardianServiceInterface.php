<?php

namespace App\Http\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface GuardianServiceInterface
{
    public function getAll(Request $request): LengthAwarePaginator|Collection;
    public function getById(int $id): ?User;
    public function create(array $data): User;
    public function update(int $id, array $data): User;
    public function delete(int $id): bool;
}
