<?php

namespace App\Http\Services;

use App\Http\Contracts\SchoolServiceInterface;
use App\Models\School;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SchoolService implements SchoolServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['address', 'logo_image', 'school_type', 'education_board'];

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(School::with($this->resource), request());
    }

    public function getById(int $id): ?School
    {
        return School::find($id);
    }

    public function create(array $data): School
    {
        return School::create($data);
    }

    public function update(int $id, array $data): School
    {
        $model = School::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) School::destroy($id);
    }
}
