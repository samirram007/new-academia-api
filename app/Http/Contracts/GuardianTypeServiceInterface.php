<?php

namespace App\Http\Contracts;

use App\Models\GuardianType;
use Illuminate\Database\Eloquent\Collection;

interface GuardianTypeServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?GuardianType;
    public function create(array $data): GuardianType;
    public function update(int $id, array $data): GuardianType;
    public function delete(int $id): bool;
}
