<?php

namespace App\Http\Services;

use App\Http\Contracts\FeeServiceInterface;
use App\Models\Fee;
use App\Traits\HasAcademicSession;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class FeeService implements FeeServiceInterface
{
    use HasAcademicSession, HasAdvancedFilter;

    protected $resource = [
        'fee_template',
        'academic_session',
        'student',
        'academic_class',
        'campus',
        'student_session',
        'student_session.campus',
        'student_session.academic_class',
        'student_session.academic_session',
        'student_session.section',
        'student_session.fee_item_months',
        'fee_items',
        'fee_items.fee_head',
        'fee_items.fee_item_months',
        'fee_items.fee_item_months.month',
        'campus',
        'campus.school',
        'campus.school.address',
        'campus.school.logo_image',
    ];

    public function getAll(): LengthAwarePaginator|Collection
    {
        $academicSessionId = $this->resolveAcademicSessionId(request());

        $query = Fee::with($this->resource)
            ->where('academic_session_id', $academicSessionId)
            ->where('is_deleted', '!=', 1)
            ->orderBy('id', 'desc');
        return $this->applyAdvancedFilter($query, request());
    }



    public function getById(int $id): ?Fee
    {
        return Fee::with($this->resource)->find($id);
    }

    public function create(array $data): Fee
    {
        return Fee::create($data);
    }

    public function update(int $id, array $data): Fee
    {
        $model = Fee::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Fee::destroy($id);
    }
}
