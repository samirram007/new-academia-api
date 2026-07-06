<?php

namespace App\Http\Services;

use App\Http\Contracts\SettingServiceInterface;
use App\Models\Setting;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SettingService implements SettingServiceInterface
{
    use HasAdvancedFilter;

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(Setting::where('user_id', request()->user()->id), request());
    }

    public function getById(int $id): ?Setting
    {
        return Setting::find($id);
    }

    public function create(array $data): Setting
    {
        return Setting::create($data);
    }

    public function update(int $id, array $data): Setting
    {
        $model = Setting::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Setting::destroy($id);
    }
}
