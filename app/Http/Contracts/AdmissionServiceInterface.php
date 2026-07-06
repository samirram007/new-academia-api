<?php

namespace App\Http\Contracts;

use App\Models\Admission;
use Illuminate\Database\Eloquent\Collection;

interface AdmissionServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Admission;
    public function create(array $data): Admission;
    public function update(int $id, array $data): Admission;
    public function delete(int $id): bool;
}
