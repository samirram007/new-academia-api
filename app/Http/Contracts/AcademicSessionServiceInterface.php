<?php

namespace App\Http\Contracts;

use App\Models\AcademicSession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface AcademicSessionServiceInterface
{
    public function getAll(Request $request): LengthAwarePaginator|Collection;
    public function getById(int $id): ?AcademicSession;

    public function getCurrentAcademicSession(): ?AcademicSession;

    public function create(array $data): AcademicSession;
    public function update(int $id, array $data): AcademicSession;
    public function delete(int $id): bool;
}
