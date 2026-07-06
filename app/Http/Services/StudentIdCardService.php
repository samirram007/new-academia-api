<?php

namespace App\Http\Services;

use App\Http\Contracts\StudentIdCardServiceInterface;
use App\Models\Student;
use App\Models\User;
use App\Traits\HasAcademicSession;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class StudentIdCardService implements StudentIdCardServiceInterface
{
    use HasAcademicSession, HasAdvancedFilter;

    protected array $resource = [];

    public function __construct()
    {
        $this->resource = [
            'academic_session',
            'academic_class',
            'address',
            'address.state',
            'address.country',
            'addresses',
            'addresses.state',
            'addresses.country',
            'designation',
            'department',
            'profile_document',
            'guardians',
            'student_sessions',
            'student_sessions.next_student_session',
            'student_sessions.previous_student_session',
            'student_sessions.academic_class',
            'student_sessions.academic_session',
            'student_sessions.section'
        ];
    }

    public function getAll(Request $request): LengthAwarePaginator|Collection
    {
        // If required filter is missing, return empty paginated result
        if (!$request->has('academic_class_id')) {
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, (int) $request->input('per_page', 10), 1);
        }
        $query = Student::with($this->resource)
            ->whereIn('id', function ($query) use ($request) {
                $query->select('student_id')
                    ->from('student_sessions')
                    ->where('academic_session_id', $request->input('academic_session_id'))
                    ->where('academic_class_id', $request->input('academic_class_id'));
            });

        return $this->applyAdvancedFilter($query, $request, ['searchable' => ['name', 'username', 'email', 'contact_no', 'admission_no', 'code']]);
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
        $student = Student::findOrFail($id);
        $student->update($data);
        return $student;
    }

    public function delete(int $id): bool
    {
        return (bool) Student::destroy($id);
    }
}
