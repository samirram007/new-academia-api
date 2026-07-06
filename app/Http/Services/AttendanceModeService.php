<?php

namespace App\Http\Services;

use App\Http\Contracts\AttendanceModeServiceInterface;
use App\Models\AttendanceMode;
use Illuminate\Database\Eloquent\Collection;

class AttendanceModeService implements AttendanceModeServiceInterface
{
    public function getAll(): Collection
    {
        return AttendanceMode::all();
    }

    public function getById(int $id): ?AttendanceMode
    {
        return AttendanceMode::find($id);
    }

    public function create(array $data): AttendanceMode
    {
        return AttendanceMode::create($data);
    }

    public function update(int $id, array $data): AttendanceMode
    {
        $model = AttendanceMode::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) AttendanceMode::destroy($id);
    }
}
