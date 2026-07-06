<?php

namespace App\Http\Services;

use App\Http\Contracts\AddressServiceInterface;
use App\Models\Address;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AddressService implements AddressServiceInterface
{
    use HasAdvancedFilter;

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(Address::query(), request());
    }

    public function getById(int $id): ?Address
    {
        return Address::find($id);
    }

    public function create(array $data): Address
    {
        return Address::create($data);
    }

    public function update(int $id, array $data): Address
    {
        $model = Address::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Address::destroy($id);
    }
}
