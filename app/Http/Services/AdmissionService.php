<?php

namespace App\Http\Services;

use App\Http\Contracts\AdmissionServiceInterface;
use App\Models\Admission;
use Illuminate\Database\Eloquent\Collection;

class AdmissionService implements AdmissionServiceInterface
{
    public function getAll(): Collection
    {
        return Admission::all();
    }

    public function getById(int $id): ?Admission
    {
        return Admission::find($id);
    }

    public function create(array $data): Admission
    {
        return Admission::create($data);
    }

    public function update(int $id, array $data): Admission
    {
        $model = Admission::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Admission::destroy($id);
    }
}
