<?php

namespace App\Http\Services;

use App\Http\Contracts\AttendanceServiceInterface;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Collection;

class AttendanceService implements AttendanceServiceInterface
{
    public function getAll(): Collection
    {
        return Attendance::all();
    }

    public function getById(int $id): ?Attendance
    {
        return Attendance::find($id);
    }

    public function create(array $data): Attendance
    {
        return Attendance::create($data);
    }

    public function update(int $id, array $data): Attendance
    {
        $model = Attendance::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Attendance::destroy($id);
    }
}
