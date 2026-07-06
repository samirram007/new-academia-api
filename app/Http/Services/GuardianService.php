<?php

namespace App\Http\Services;

use App\Http\Contracts\GuardianServiceInterface;
use App\Models\StudentGuardian;
use App\Models\User;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class GuardianService implements GuardianServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['designation', 'department', 'profile_document'];

    public function getAll(Request $request): LengthAwarePaginator|Collection
    {
        $query = User::with($this->resource)->where('user_type', 'guardian');
        return $this->applyAdvancedFilter($query, $request, ['searchable' => ['name', 'username', 'email', 'contact_no', 'code']]);
    }

    public function getById(int $id): ?User
    {
        return User::with($this->resource)->find($id);
    }

    public function create(array $data): User
    {
        $user = User::create($data);

        if (isset($data['student_id'])) {
            $studentGuardian = new StudentGuardian();
            $studentGuardian->guardian_id = $user->id;
            $studentGuardian->student_id = $data['student_id'];
            $studentGuardian->save();
        }

        return $user;
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
