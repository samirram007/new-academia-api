<?php

namespace App\Http\Services;

use App\Http\Contracts\StudentSessionServiceInterface;
use App\Models\StudentSession;
use App\Traits\HasAcademicSession;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class StudentSessionService implements StudentSessionServiceInterface
{
    use HasAcademicSession, HasAdvancedFilter;

    protected $foreignLoader = ['student', 'student.profile_document', 'academic_session', 'academic_class', 'academic_standard'];

    public function getForeignLoader(): array
    {
        return $this->foreignLoader;
    }

    public function getAll(): LengthAwarePaginator|Collection
    {
        $academicSessionId = $this->resolveAcademicSessionId(request());

        request()->merge(['academic_session_id' => $academicSessionId]);

        if (!request()->has('campus_id')) {
            abort(400, json_encode([
                'status' => false,
                'message' => ['Please provide campus'],
            ]));
        }

        $query = StudentSession::with($this->foreignLoader)
            ->where('academic_session_id', request()->input('academic_session_id'));
        if (request()->has('academic_class_id')) {
            $query->where('academic_class_id', request()->input('academic_class_id'));
        }
        return $this->applyAdvancedFilter($query, request());
    }

    public function getById(int $id): ?StudentSession
    {
        return StudentSession::find($id);
    }

    public function create(array $data): StudentSession
    {
        return StudentSession::create($data);
    }

    public function update(int $id, array $data): StudentSession
    {
        $model = StudentSession::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) StudentSession::destroy($id);
    }
}
