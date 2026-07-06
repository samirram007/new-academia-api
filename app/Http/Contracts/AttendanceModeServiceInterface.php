<?php

namespace App\Http\Contracts;

use App\Models\AttendanceMode;
use Illuminate\Database\Eloquent\Collection;

interface AttendanceModeServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?AttendanceMode;
    public function create(array $data): AttendanceMode;
    public function update(int $id, array $data): AttendanceMode;
    public function delete(int $id): bool;
}
