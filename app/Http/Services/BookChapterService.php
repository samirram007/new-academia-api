<?php

namespace App\Http\Services;

use App\Http\Contracts\BookChapterServiceInterface;
use App\Models\BookChapter;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BookChapterService implements BookChapterServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['book'];

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(BookChapter::with($this->resource), request());
    }

    public function getById(int $id): ?BookChapter
    {
        return BookChapter::with($this->resource)->find($id);
    }

    public function create(array $data): BookChapter
    {
        return BookChapter::create($data);
    }

    public function update(int $id, array $data): BookChapter
    {
        $model = BookChapter::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) BookChapter::destroy($id);
    }
}
