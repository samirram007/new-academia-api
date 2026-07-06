<?php

namespace App\Http\Services;

use App\Http\Contracts\RoomServiceInterface;
use App\Models\Room;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RoomService implements RoomServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['floor', 'floor.building', 'floor.building.campus'];

    public function getAll(): LengthAwarePaginator|Collection
    {
        if (!request()->has('floor_id')) {
            abort(400, json_encode([
                'status' => false,
                'message' => ['Please provide floor_id'],
            ]));
        }

        return $this->applyAdvancedFilter(
            Room::with($this->resource)->where('floor_id', request()->input('floor_id')),
            request()
        );
    }

    public function getById(int $id): ?Room
    {
        return Room::find($id);
    }

    public function create(array $data): Room
    {
        return Room::create($data);
    }

    public function update(int $id, array $data): Room
    {
        $model = Room::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Room::destroy($id);
    }
}
