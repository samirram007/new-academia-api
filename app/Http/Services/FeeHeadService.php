<?php

namespace App\Http\Services;

use App\Http\Contracts\FeeHeadServiceInterface;
use App\Models\FeeHead;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;


class FeeHeadService implements FeeHeadServiceInterface
{
    use HasAdvancedFilter;

    protected array $resource = ['income_group'];



    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(FeeHead::with($this->resource), request());
    }

    public function getById(int $id): ?FeeHead
    {
        return FeeHead::with($this->resource)->find($id);
    }

    public function create(array $data): FeeHead
    {
        return FeeHead::create($data);
    }

    public function update(int $id, array $data): FeeHead
    {
        $model = FeeHead::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) FeeHead::destroy($id);
    }
}
