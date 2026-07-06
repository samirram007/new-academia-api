<?php

namespace App\Http\Services;

use App\Http\Contracts\FeeItemServiceInterface;
use App\Models\FeeItem;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FeeItemService implements FeeItemServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['fee_item_months'];

    public function getAll(Request $request): LengthAwarePaginator|Collection
    {
        $query = FeeItem::with($this->resource);
        return $this->applyAdvancedFilter($query, $request);
    }

    public function getById(int $id): ?FeeItem
    {
        return FeeItem::with($this->resource)->find($id);
    }

    public function create(array $data): FeeItem
    {
        return FeeItem::create($data);
    }

    public function update(int $id, array $data): FeeItem
    {
        $model = FeeItem::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) FeeItem::destroy($id);
    }
}
