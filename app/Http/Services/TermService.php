<?php

namespace App\Http\Services;

use App\Http\Contracts\TermServiceInterface;
use App\Models\Term;
use Illuminate\Database\Eloquent\Collection;

class TermService implements TermServiceInterface
{
    public function getAll(): Collection
    {
        return Term::all();
    }

    public function getById(int $id): ?Term
    {
        return Term::find($id);
    }

    public function create(array $data): Term
    {
        return Term::create($data);
    }

    public function update(int $id, array $data): Term
    {
        $model = Term::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Term::destroy($id);
    }
}
