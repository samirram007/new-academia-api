<?php

namespace App\Http\Services;

use App\Http\Contracts\StudentServiceInterface;
use App\Http\Facades\UserFacade;
use App\Models\User;
use App\Traits\HasAcademicSession;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class StudentService implements StudentServiceInterface
{
    use HasAcademicSession, HasAdvancedFilter;

    protected array $resource = [];

    public function __construct()
    {
        $this->resource = [
            'academic_session',
            'academic_class',
            'campus',
            'addresses' => function ($query) {
                $query->with(['state', 'country']);
            },
            'designation',
            'department',
            'profile_document',
            'guardians' => function ($query) {
                $query->where('guardian_type', '!=', null)
                    ->where('user_type', '=', 'guardian');
            },
            'student_sessions' => function ($query) {
                $query->where('academic_session_id', '!=', 0)
                    ->where('academic_session_id', '!=', null)
                    ->with([
                        'campus',
                        'academic_class',
                        'academic_session',
                        'section',
                        'fee_item_months' => function ($query) {
                            $query->where('is_deleted', '!=', 1)
                                ->with(['month']);
                        }
                    ]);
            }
        ];
    }

    public function getAll(Request $request): LengthAwarePaginator|Collection
    {
        if (!$request->has('filter_option')) {
            abort(400, json_encode(['success' => false, 'message' => ['Please provide filter option']]));
        }

        if ($request->input('filter_option') == 'active') {
            return $this->getActiveStudents($request);
        } elseif ($request->input('filter_option') == 'admission') {
            return $this->getAdmissionStudents($request);
        }

        abort(400, json_encode(['success' => false, 'message' => 'Please select Filter Option']));
    }

    protected function getActiveStudents(Request $request): LengthAwarePaginator|Collection
    {
        $academicSessionId = $this->resolveAcademicSessionId($request);

        $query = User::with($this->resource)
            ->where('user_type', 'student')
            ->whereIn('id', function ($query) use ($request) {
                $query->select('student_id')
                    ->from('student_sessions')
                    ->whereIn('academic_session_id', [$request->input('academic_session_id')]);

                // -1 means all classes — skip the filter
                $classId = $request->input('academic_class_id');
                if ($classId !== null && $classId !== '' && $classId !== '-1') {
                    $query->whereIn('academic_class_id', [$classId]);
                }
            });

        return $this->applyAdvancedFilter($query, request(), ['searchable' => ['name', 'username', 'email', 'contact_no', 'admission_no', 'code']]);
    }

    protected function getAdmissionStudents(Request $request): LengthAwarePaginator|Collection
    {
        $academicSessionId = $this->resolveAcademicSessionId($request);

        $query = User::with($this->resource)
            ->where('user_type', 'student');

        $query->where('academic_session_id', $academicSessionId);
        if ($request->has('academic_class_id')) {
            $query->where('academic_class_id', $request->input('academic_class_id'));
        }

        $query->whereNotIn('id', function ($subQuery) use ($academicSessionId) {
            $subQuery->select('student_id')
                ->from('student_sessions')
                ->where('academic_session_id', $academicSessionId);
        });

        return $this->applyAdvancedFilter($query, $request, ['searchable' => ['name', 'username', 'email', 'contact_no', 'admission_no', 'code']]);
    }

    public function getById(int $id): ?User
    {
        return User::with($this->resource)->find($id);
    }

    public function create(array $data): User
    {
        return UserFacade::createUser($data);
    }

    public function update(int $id, array $data): User
    {
        $student = UserFacade::update($id, $data);

        return $student;
    }

    public function delete(int $id): bool
    {
        return (bool) UserFacade::delete($id);
    }
}
