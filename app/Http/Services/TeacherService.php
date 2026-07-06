<?php

namespace App\Http\Services;

use App\Http\Contracts\TeacherServiceInterface;
use App\Models\User;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class TeacherService implements TeacherServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = [];

    public function getAll(Request $request): LengthAwarePaginator|Collection
    {
        $query = User::query()->where('user_type', 'teacher');
        return $this->applyAdvancedFilter($query, $request, ['searchable' => ['name', 'username', 'email', 'contact_no', 'code']]);
    }

    public function getById(int $id): ?User
    {
        return User::with($this->resource)
            ->where('user_type', 'teacher')
            ->find($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(int $id, array $data): User
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete(int $id): bool
    {
        $user = User::find($id);
        if ($user) {
            return (bool) $user->delete();
        }
        return false;
    }
}
