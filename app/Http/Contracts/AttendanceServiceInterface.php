<?php

namespace App\Http\Contracts;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Collection;

interface AttendanceServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Attendance;
    public function create(array $data): Attendance;
    public function update(int $id, array $data): Attendance;
    public function delete(int $id): bool;
}
