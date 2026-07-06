<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Fee;
use App\Models\FeeReceipt;
use App\Models\StudentSession;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use App\Traits\HasAcademicSession;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ApiResponseTrait, HasAcademicSession;

    public function index(Request $request)
    {
        $academicSessionId = $this->getAcademicSessionId($request);

        // ── User Counts ──────────────────────────────────────────────
        $totalStudents = User::where('user_type', 'student')->count();
        $activeStudents = StudentSession::when($academicSessionId, fn ($q) => $q->where('academic_session_id', $academicSessionId))
            ->distinct('student_id')
            ->count('student_id');
        $totalTeachers = User::where('user_type', 'teacher')->count();
        $totalStaff = User::whereIn('user_type', ['admin', 'staff'])->count();

        // ── Fee Stats ────────────────────────────────────────────────
        $feesQuery = Fee::query();
        if ($academicSessionId) {
            $feesQuery->where('academic_session_id', $academicSessionId);
        }
        $totalFeeAmount = (float) $feesQuery->sum('total_amount');
        $totalFeePaid = (float) $feesQuery->sum('paid_amount');
        $totalFeeDue = (float) $feesQuery->sum('balance_amount');
        $totalFeeCount = $feesQuery->count();

        // ── Expense Stats ────────────────────────────────────────────
        $expensesQuery = Expense::query();
        if ($academicSessionId) {
            $expensesQuery->where('academic_session_id', $academicSessionId);
        }
        $totalExpenseAmount = (float) $expensesQuery->sum('total_amount');
        $totalExpensePaid = (float) $expensesQuery->sum('paid_amount');
        $totalExpenseCount = $expensesQuery->count();

        // ── Receipts (recent collections) ────────────────────────────
        $recentReceipts = FeeReceipt::with('paidBy')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'receipt_no' => $r->receipt_no,
                'amount' => (float) $r->amount,
                'payment_mode' => $r->payment_mode,
                'receipt_date' => $r->receipt_date?->format('Y-m-d'),
                'paid_by' => $r->paidBy?->name,
            ]);

        // ── Recent Fees (last 90 days if no session specified) ───────
        $recentFees = Fee::with('student')
            ->when(!$academicSessionId, fn ($q) => $q->where('created_at', '>=', now()->subDays(90)))
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(fn ($f) => [
                'id' => $f->id,
                'fee_no' => $f->fee_no,
                'student_name' => $f->student?->name,
                'total_amount' => (float) $f->total_amount,
                'paid_amount' => (float) $f->paid_amount,
                'balance_amount' => (float) $f->balance_amount,
                'fee_date' => $f->fee_date,
                'payment_mode' => $f->payment_mode,
            ]);

        // ── Monthly Collection Summary (last 6 months) ───────────────
        $monthlyCollection = collect();
        $driver = \DB::connection()->getDriverName();
        if (in_array($driver, ['mysql', 'mariadb'])) {
            $monthExpr = \DB::raw("DATE_FORMAT(fee_date, '%Y-%m') as month");
            $groupExpr = \DB::raw("DATE_FORMAT(fee_date, '%Y-%m')");
        } else {
            $monthExpr = \DB::raw("strftime('%Y-%m', fee_date) as month");
            $groupExpr = \DB::raw("strftime('%Y-%m', fee_date)");
        }
        $monthlyCollection = Fee::selectRaw("SUM(total_amount) as total, SUM(paid_amount) as paid, SUM(balance_amount) as due")
            ->select([$monthExpr])
            ->when($academicSessionId, fn ($q) => $q->where('academic_session_id', $academicSessionId))
            ->whereNotNull('fee_date')
            ->groupBy($groupExpr)
            ->orderBy('month', 'desc')
            ->take(6)
            ->get()
            ->map(fn ($m) => [
                'month' => $m->month,
                'total' => (float) $m->total,
                'paid' => (float) $m->paid,
                'due' => (float) $m->due,
            ]);

        // ── Class-wise Student Count ─────────────────────────────────
        $studentsByClass = StudentSession::with('academic_class')
            ->when($academicSessionId, fn ($q) => $q->where('academic_session_id', $academicSessionId))
            ->selectRaw('academic_class_id, COUNT(DISTINCT student_id) as count')
            ->groupBy('academic_class_id')
            ->orderByDesc('count')
            ->get()
            ->map(fn ($s) => [
                'class_name' => $s->academic_class?->name ?? 'Unknown',
                'count' => (int) $s->count,
            ]);

        return $this->successResponse([
            'summary' => [
                'total_students' => $totalStudents,
                'active_students' => $activeStudents,
                'total_teachers' => $totalTeachers,
                'total_staff' => $totalStaff,
                'total_fee_amount' => $totalFeeAmount,
                'total_fee_paid' => $totalFeePaid,
                'total_fee_due' => $totalFeeDue,
                'total_fee_count' => $totalFeeCount,
                'total_expense_amount' => $totalExpenseAmount,
                'total_expense_paid' => $totalExpensePaid,
                'total_expense_count' => $totalExpenseCount,
            ],
            'recent_receipts' => $recentReceipts,
            'recent_fees' => $recentFees,
            'monthly_collection' => $monthlyCollection,
            'students_by_class' => $studentsByClass,
        ]);
    }
}
