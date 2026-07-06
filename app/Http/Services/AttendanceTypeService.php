<?php

namespace App\Http\Services;

use App\Http\Contracts\AttendanceTypeServiceInterface;
use App\Models\AttendanceType;
use Illuminate\Database\Eloquent\Collection;

class AttendanceTypeService implements AttendanceTypeServiceInterface
{
    public function getAll(): Collection
    {
        return AttendanceType::all();
    }

    public function getById(int $id): ?AttendanceType
    {
        return AttendanceType::find($id);
    }

    public function create(array $data): AttendanceType
    {
        return AttendanceType::create($data);
    }

    public function update(int $id, array $data): AttendanceType
    {
        $model = AttendanceType::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) AttendanceType::destroy($id);
    }
}
