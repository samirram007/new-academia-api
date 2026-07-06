<?php

namespace App\Http\Services;

use App\Http\Contracts\StateServiceInterface;
use App\Models\State;
use Illuminate\Database\Eloquent\Collection;

class StateService implements StateServiceInterface
{
    public function getAll(): Collection
    {
        return State::all();
    }

    public function getById(int $id): ?State
    {
        return State::find($id);
    }

    public function create(array $data): State
    {
        return State::create($data);
    }

    public function update(int $id, array $data): State
    {
        $model = State::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) State::destroy($id);
    }
}
