<?php

namespace App\Http\Contracts;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

interface CountryServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Country;
    public function create(array $data): Country;
    public function update(int $id, array $data): Country;
    public function delete(int $id): bool;
}
