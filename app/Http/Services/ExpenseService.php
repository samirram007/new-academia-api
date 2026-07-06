<?php

namespace App\Http\Services;

use App\Http\Contracts\ExpenseServiceInterface;
use App\Models\Expense;
use App\Traits\HasAcademicSession;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ExpenseService implements ExpenseServiceInterface
{
    use HasAcademicSession, HasAdvancedFilter;

    protected $resource = ['academic_session', 'expense_items', 'expense_items.expense_head'];

    public function getAll(): LengthAwarePaginator|Collection
    {
        $academicSessionId = $this->resolveAcademicSessionId(request());

        if (!$academicSessionId) {
            abort(400, json_encode([
                'status' => false,
                'message' => ['Please configure your academic session first.'],
            ]));
        }

        request()->merge(['academic_session_id' => $academicSessionId]);

        return $this->applyAdvancedFilter(
            Expense::with($this->resource)
                ->where('academic_session_id', request()->input('academic_session_id'))
                ->orderBy('expense_date', 'desc')
                ->orderBy('id', 'desc'),
            request(),
            ['dateField' => 'expense_date']
        );
    }

    public function getById(int $id): ?Expense
    {
        return Expense::find($id);
    }

    public function create(array $data): Expense
    {
        return Expense::create($data);
    }

    public function update(int $id, array $data): Expense
    {
        $model = Expense::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Expense::destroy($id);
    }
}
