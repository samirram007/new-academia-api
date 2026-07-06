<?php

namespace App\Http\Services;

use App\Http\Contracts\PromotionServiceInterface;
use App\Models\Promotion;
use App\Models\User;
use App\Traits\HasAcademicSession;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PromotionService implements PromotionServiceInterface
{
    use HasAcademicSession, HasAdvancedFilter;

    protected $resource = ['academic_session', 'academic_class', 'campus', 'address', 'address.state', 'address.country', 'addresses', 'addresses.state', 'addresses.country',
        'designation', 'department', 'profile_document', 'guardians',
        'student_sessions', 'student_sessions.next_student_session', 'student_sessions.previous_student_session', 'student_sessions.academic_class', 'student_sessions.academic_session', 'student_sessions.section'];

    protected $foreignLoader = ['student', 'student.profile_document', 'academic_session', 'academic_class', 'academic_standard'];

    public function getForeignLoader(): array
    {
        return $this->foreignLoader;
    }

    public function getAll(): LengthAwarePaginator|Collection
    {
        $query = Promotion::with([
            'student',
            'oldAcademicSession',
            'newAcademicSession',
            'oldAcademicClass',
            'newAcademicClass',
            'oldCampus',
            'newCampus',
        ]);

        // Apply filter dropdown params as WHERE conditions
        $filterable = ['old_academic_session_id', 'new_academic_session_id', 'old_academic_class_id', 'new_academic_class_id', 'old_campus_id', 'new_campus_id'];
        foreach ($filterable as $field) {
            if (request()->has($field) && request()->filled($field)) {
                $query->where($field, request()->input($field));
            }
        }

        return $this->applyAdvancedFilter($query, request());
    }

    /**
     * Get students for batch promotion (legacy behavior).
     */
    public function getStudentsForPromotion(): LengthAwarePaginator|Collection
    {
        $academicSessionId = $this->resolveAcademicSessionId(request());

        if (!request()->has('academic_class_id')) {
            abort(400, json_encode([
                'status' => false,
                'message' => ['Please provide academic class'],
            ]));
        }

        request()->merge(['academic_session_id' => $academicSessionId]);

        $thisLoader = ['academic_session', 'academic_class', 'campus',
            'designation', 'department', 'profile_document', 'guardians',
            'student_sessions' => function ($query) {
                $query->with([
                    'next_student_session',
                    'previous_student_session',
                    'academic_class',
                    'academic_session',
                    'section',
                ])->where('academic_session_id', request()->input('academic_session_id'));
            },
        ];

        $query = User::with($thisLoader)
            ->where('user_type', 'student')
            ->whereIn('id', function ($query) {
                $query->select('student_id')
                    ->from('student_sessions')
                    ->where('academic_session_id', request()->input('academic_session_id'))
                    ->where('academic_class_id', request()->input('academic_class_id'));
                if (request()->has('section_id') && request()->input('section_id')) {
                    $query->where('section_id', request()->input('section_id'));
                }
            });

        return $this->applyAdvancedFilter($query, request());
    }

    public function getById(int $id): ?Promotion
    {
        return Promotion::with([
            'student',
            'oldAcademicSession',
            'newAcademicSession',
            'oldAcademicClass',
            'newAcademicClass',
            'oldCampus',
            'newCampus',
        ])->find($id);
    }

    public function create(array $data): Promotion
    {
        return Promotion::create($data);
    }

    public function update(int $id, array $data): Promotion
    {
        $model = Promotion::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Promotion::destroy($id);
    }
}
