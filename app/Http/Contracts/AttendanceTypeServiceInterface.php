<?php

namespace App\Http\Contracts;

use App\Models\AttendanceType;
use Illuminate\Database\Eloquent\Collection;

interface AttendanceTypeServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?AttendanceType;
    public function create(array $data): AttendanceType;
    public function update(int $id, array $data): AttendanceType;
    public function delete(int $id): bool;
}
