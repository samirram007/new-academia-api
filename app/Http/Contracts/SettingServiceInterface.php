<?php

namespace App\Http\Contracts;

use App\Models\Setting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SettingServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Setting;
    public function create(array $data): Setting;
    public function update(int $id, array $data): Setting;
    public function delete(int $id): bool;
}
