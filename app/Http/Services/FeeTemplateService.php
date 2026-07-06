<?php

namespace App\Http\Services;

use App\Http\Contracts\FeeTemplateServiceInterface;
use App\Models\FeeTemplate;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class FeeTemplateService implements FeeTemplateServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['campus', 'academic_class', 'fee_template_items', 'fee_template_items.fee_head'];

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(
            FeeTemplate::with($this->resource)
                ->withCount('fees')
                ->where('academic_class_id', request()->input('academic_class_id'))
                ->orderBy('is_active', 'desc')
                ->orderBy('name', 'asc'),
            request()
        );
    }

    public function getById(int $id): ?FeeTemplate
    {
        return FeeTemplate::find($id);
    }

    public function create(array $data): FeeTemplate
    {
        return FeeTemplate::create($data);
    }

    public function update(int $id, array $data): FeeTemplate
    {
        $model = FeeTemplate::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) FeeTemplate::destroy($id);
    }
}
