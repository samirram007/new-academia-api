<?php

namespace App\Http\Services;

use App\Http\Contracts\AcademicClassServiceInterface;
use App\Models\AcademicClass;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AcademicClassService implements AcademicClassServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['campus', 'academic_standard'];

    public function getAll(): LengthAwarePaginator|Collection
    {

        return $this->applyAdvancedFilter(AcademicClass::with($this->resource), request());
    }



    public function getById(int $id): ?AcademicClass
    {
        return AcademicClass::with($this->resource)->find($id);
    }

    public function create(array $data): AcademicClass
    {
        return AcademicClass::create($data);
    }

    public function update(int $id, array $data): AcademicClass
    {
        return \DB::transaction(function () use ($id, $data) {
            $academicClass = AcademicClass::findOrFail($id);

            if ($data['campus_id'] == $academicClass->campus_id) {
                $academicClass->update($data);
                return $academicClass;
            }

            \App\Models\StudentSession::where('academic_class_id', $academicClass->id)
                ->update(['campus_id' => $data['campus_id']]);

            \App\Models\Fee::where('academic_class_id', $academicClass->id)
                ->update(['campus_id' => $data['campus_id']]);

            \App\Models\User::where('academic_class_id', $academicClass->id)
                ->update(['campus_id' => $data['campus_id']]);

            \App\Models\FeeTemplate::where('academic_class_id', $academicClass->id)
                ->update(['campus_id' => $data['campus_id']]);

            $academicClass->update($data);
            return $academicClass;
        });
    }

    public function delete(int $id): bool
    {
        return (bool) AcademicClass::destroy($id);
    }
}
