<?php

namespace App\Http\Contracts;

use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface StudentIdCardServiceInterface
{
    public function getAll(Request $request): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Student;
    public function create(array $data): Student;
    public function update(int $id, array $data): Student;
    public function delete(int $id): bool;
}
