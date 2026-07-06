<?php

namespace App\Http\Services;

use App\Http\Contracts\CountryServiceInterface;
use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

class CountryService implements CountryServiceInterface
{
    public function getAll(): Collection
    {
        return Country::all();
    }

    public function getById(int $id): ?Country
    {
        return Country::find($id);
    }

    public function create(array $data): Country
    {
        return Country::create($data);
    }

    public function update(int $id, array $data): Country
    {
        $model = Country::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Country::destroy($id);
    }
}
