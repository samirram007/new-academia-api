<?php

namespace App\Http\Services;

use App\Http\Contracts\SectionServiceInterface;
use App\Models\Section;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SectionService implements SectionServiceInterface
{
    use HasAdvancedFilter;

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(Section::query(), request());
    }

    public function getById(int $id): ?Section
    {
        return Section::find($id);
    }

    public function create(array $data): Section
    {
        return Section::create($data);
    }

    public function update(int $id, array $data): Section
    {
        $model = Section::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Section::destroy($id);
    }
}
