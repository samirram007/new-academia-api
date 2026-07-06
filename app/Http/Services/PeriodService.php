<?php

namespace App\Http\Services;

use App\Http\Contracts\PeriodServiceInterface;
use App\Models\Period;
use Illuminate\Database\Eloquent\Collection;

class PeriodService implements PeriodServiceInterface
{
    public function getAll(): Collection
    {
        return Period::all();
    }

    public function getById(int $id): ?Period
    {
        return Period::find($id);
    }

    public function create(array $data): Period
    {
        return Period::create($data);
    }

    public function update(int $id, array $data): Period
    {
        $model = Period::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Period::destroy($id);
    }
}
