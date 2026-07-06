<?php

namespace App\Http\Services;

use App\Http\Contracts\BookServiceInterface;
use App\Models\Book;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BookService implements BookServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['subject'];

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(Book::with($this->resource), request());
    }

    public function getById(int $id): ?Book
    {
        return Book::with($this->resource)->find($id);
    }

    public function create(array $data): Book
    {
        return Book::create($data);
    }

    public function update(int $id, array $data): Book
    {
        $model = Book::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Book::destroy($id);
    }
}
