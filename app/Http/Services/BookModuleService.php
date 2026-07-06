<?php

namespace App\Http\Services;

use App\Http\Contracts\BookModuleServiceInterface;
use App\Models\BookModule;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BookModuleService implements BookModuleServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['book'];

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(BookModule::with($this->resource), request());
    }

    public function getById(int $id): ?BookModule
    {
        return BookModule::with($this->resource)->find($id);
    }

    public function create(array $data): BookModule
    {
        return BookModule::create($data);
    }

    public function update(int $id, array $data): BookModule
    {
        $model = BookModule::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) BookModule::destroy($id);
    }
}
