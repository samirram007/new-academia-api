<?php

namespace App\Http\Contracts;

use App\Models\State;
use Illuminate\Database\Eloquent\Collection;

interface StateServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?State;
    public function create(array $data): State;
    public function update(int $id, array $data): State;
    public function delete(int $id): bool;
}
