<?php

namespace App\Http\Services;

use App\Http\Contracts\CampusAcademicSessionServiceInterface;
use App\Models\CampusAcademicSession;
use Illuminate\Database\Eloquent\Collection;

class CampusAcademicSessionService implements CampusAcademicSessionServiceInterface
{
    public function getAll(): Collection
    {
        return CampusAcademicSession::all();
    }

    public function getById(int $id): ?CampusAcademicSession
    {
        return CampusAcademicSession::find($id);
    }

    public function create(array $data): CampusAcademicSession
    {
        return CampusAcademicSession::create($data);
    }

    public function update(int $id, array $data): CampusAcademicSession
    {
        $model = CampusAcademicSession::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) CampusAcademicSession::destroy($id);
    }
}
