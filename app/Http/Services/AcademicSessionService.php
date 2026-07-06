<?php

namespace App\Http\Services;


use App\Http\Contracts\AcademicSessionServiceInterface;
use App\Models\AcademicSession;
use App\Traits\HasAdvancedFilter;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AcademicSessionService implements AcademicSessionServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['previous_academic_session', 'next_academic_session'];

    public function getAll(Request $request): LengthAwarePaginator|Collection
    {
        $query = AcademicSession::with($this->resource);

        return $this->applyAdvancedFilter($query, request());
    }

    public function getById(int $id): ?AcademicSession
    {
        return AcademicSession::with($this->resource)->find($id);
    }

    public function getCurrentAcademicSession(): ?AcademicSession
    {
        // /desc Order by id
        return AcademicSession::where('is_current', 1)->latest('id')->first();
    }

    public function create(array $data): AcademicSession
    {
        return AcademicSession::create($data);
    }

    public function update(int $id, array $data): AcademicSession
    {
        $session = AcademicSession::findOrFail($id);
        $session->update($data);
        return $session;
    }

    public function delete(int $id): bool
    {
        return (bool) AcademicSession::destroy($id);
    }
}
