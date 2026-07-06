<?php

namespace App\Http\Contracts;

use App\Models\StudentGuardian;
use Illuminate\Database\Eloquent\Collection;

interface StudentGuardianServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?StudentGuardian;
    public function create(array $data): StudentGuardian;
    public function update(int $id, array $data): StudentGuardian;
    public function delete(int $id): bool;
}
