<?php

namespace App\Http\Services;

use App\Http\Contracts\EducationBoardServiceInterface;
use App\Models\EducationBoard;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EducationBoardService implements EducationBoardServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['address', 'logo_image'];

    public function getResource(): array
    {
        return $this->resource;
    }

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(EducationBoard::with($this->resource), request());
    }

    public function getById(int $id): ?EducationBoard
    {
        return EducationBoard::find($id);
    }

    public function create(array $data): EducationBoard
    {
        return EducationBoard::create($data);
    }

    public function update(int $id, array $data): EducationBoard
    {
        $model = EducationBoard::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) EducationBoard::destroy($id);
    }
}
