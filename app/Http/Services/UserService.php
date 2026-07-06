<?php

namespace App\Http\Services;


use App\Http\Contracts\UserServiceInterface;
use App\Models\User;
use App\Traits\HasAdvancedFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserService implements UserServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['address', 'address.state', 'address.country', 'addresses', 'addresses.state', 'addresses.country', 'designation', 'department', 'profile_document', 'guardians'];





    public function getAll(int $perPage = 15): LengthAwarePaginator|Collection
    {

        $query = User::with($this->resource);
        if (request()->has('user_type')) {
            $query->where('user_type', request()->input('user_type'));
        }
        return $this->applyAdvancedFilter($query, request(), ['searchable' => ['name', 'username', 'email', 'contact_no', 'code'], 'per_page' => $perPage]);
    }

    public function getById(int $id): ?User
    {
        return User::with($this->resource)->find($id);
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
        return (bool) User::destroy($id);
    }
}
