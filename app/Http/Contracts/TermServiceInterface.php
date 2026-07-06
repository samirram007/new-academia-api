<?php

namespace App\Http\Contracts;

use App\Models\Term;
use Illuminate\Database\Eloquent\Collection;

interface TermServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Term;
    public function create(array $data): Term;
    public function update(int $id, array $data): Term;
    public function delete(int $id): bool;
}
