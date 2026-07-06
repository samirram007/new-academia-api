<?php

namespace App\Http\Services;

use App\Http\Contracts\JourneyTypeServiceInterface;
use App\Models\JourneyType;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class JourneyTypeService implements JourneyTypeServiceInterface
{
    use HasAdvancedFilter;

    public function getAll(Request $request): LengthAwarePaginator|Collection
    {
        $query = JourneyType::query();
        return $this->applyAdvancedFilter($query, $request);
    }

    public function getById(int $id): ?JourneyType
    {
        return JourneyType::find($id);
    }

    public function create(array $data): JourneyType
    {
        return JourneyType::create($data);
    }

    public function update(int $id, array $data): JourneyType
    {
        $model = JourneyType::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) JourneyType::destroy($id);
    }
}
