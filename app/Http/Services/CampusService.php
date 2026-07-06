<?php

namespace App\Http\Services;

use App\Http\Contracts\CampusServiceInterface;
use App\Models\Campus;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CampusService implements CampusServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['address', 'logo_image', 'school', 'education_board'];

    public function getAll(Request $request): LengthAwarePaginator|Collection
    {
        $query = Campus::with($this->resource);

        return $this->applyAdvancedFilter($query, $request);
    }

    public function getById(int $id): ?Campus
    {
        return Campus::find($id);
    }

    public function create(array $data): Campus
    {
        return Campus::create($data);
    }

    public function update(int $id, array $data): Campus
    {
        $model = Campus::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Campus::destroy($id);
    }
}
