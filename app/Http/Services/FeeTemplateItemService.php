<?php

namespace App\Http\Services;

use App\Http\Contracts\FeeTemplateItemServiceInterface;
use App\Models\FeeTemplateItem;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class FeeTemplateItemService implements FeeTemplateItemServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['fee_head'];

    public function getAll(): LengthAwarePaginator|Collection
    {
        if (!request()->has('fee_template_id')) {
            abort(400, json_encode([
                'status' => false,
                'message' => ['Please provide fee template'],
            ]));
        }

        return $this->applyAdvancedFilter(
            FeeTemplateItem::with($this->resource)
                ->where('fee_template_id', request()->input('fee_template_id'))
                ->orderBy('sort_index', 'ASC'),
            request()
        );
    }

    public function getById(int $id): ?FeeTemplateItem
    {
        return FeeTemplateItem::find($id);
    }

    public function create(array $data): FeeTemplateItem
    {
        return FeeTemplateItem::create($data);
    }

    public function update(int $id, array $data): FeeTemplateItem
    {
        $model = FeeTemplateItem::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) FeeTemplateItem::destroy($id);
    }
}
