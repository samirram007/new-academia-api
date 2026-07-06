<?php

namespace App\Http\Services;

use App\Http\Contracts\StudentIdCardServiceInterface;
use App\Models\Student;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class StudentIdCardService implements StudentIdCardServiceInterface
{
    use HasAdvancedFilter;

    protected array $resource = [
        'student_sessions',
        'student_sessions.academic_session',
        'student_sessions.academic_class',
        'student_sessions.academic_standard',
        'student_sessions.section',
        'student_sessions.campus',
        'student_sessions.campus.school',
        'profile_document',
    ];

    public function getAll(Request $request): LengthAwarePaginator|Collection
    {
        $query = Student::with($this->resource);

        // Filter by academic_session_id via student_sessions
        if ($request->has('academic_session_id')) {
            $query->whereHas('student_sessions', function ($q) use ($request) {
                $q->where('academic_session_id', $request->input('academic_session_id'));
            });
        }

        // Filter by academic_class_id via student_sessions
        if ($request->has('academic_class_id')) {
            $query->whereHas('student_sessions', function ($q) use ($request) {
                $q->where('academic_class_id', $request->input('academic_class_id'));
            });
        }

        // Filter by campus_id via student_sessions
        if ($request->has('campus_id')) {
            $query->whereHas('student_sessions', function ($q) use ($request) {
                $q->where('campus_id', $request->input('campus_id'));
            });
        }

        // Filter by is_idcard_printable
        if ($request->has('is_idcard_printable')) {
            $printable = filter_var($request->input('is_idcard_printable'), FILTER_VALIDATE_BOOLEAN);
            if ($printable) {
                $query->whereHas('student_sessions', function ($q) {
                    $q->where('is_idcard_printable', true);
                });
            }
        }

        // Filter by section_id via student_sessions
        if ($request->has('section_id')) {
            $query->whereHas('student_sessions', function ($q) use ($request) {
                $q->where('section_id', $request->input('section_id'));
            });
        }

        return $this->applyAdvancedFilter($query, $request);
    }

    public function getById(int $id): ?Student
    {
        return Student::with($this->resource)->find($id);
    }

    public function create(array $data): Student
    {
        return Student::create($data);
    }

    public function update(int $id, array $data): Student
    {
        $model = Student::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Student::destroy($id);
    }
}
