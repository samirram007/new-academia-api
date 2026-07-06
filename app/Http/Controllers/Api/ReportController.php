<?php

namespace App\Http\Controllers\Api;

use App\Traits\HasAdvancedFilter;
use App\Traits\HasAcademicSession;
use App\Http\Controllers\Controller;
use App\Http\Resources\Fee\FeeCollection;
use App\Http\Resources\Fee\FeeResource;
use App\Models\Examination;
use App\Models\ExaminationStandard;
use App\Models\ExaminationResult;
use App\Models\Fee;
use App\Models\FeeHead;
use App\Models\Month;
use App\Models\StudentSession;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use HasAdvancedFilter, HasAcademicSession;

    /**
     * Examination Marksheet Report
     * Returns student-wise marks for a given examination and academic standard.
     *
     * Query params: examination_id (required), academic_standard_id (required)
     */
    public function marksheet_report(Request $request)
    {
        $examinationId = $request->input('examination_id');
        $academicStandardId = $request->input('academic_standard_id');

        if (!$examinationId || !$academicStandardId) {
            return response()->json([
                'status' => false,
                'message' => ['examination_id and academic_standard_id are required.'],
            ], 400);
        }

        // Get the examination
        $examination = Examination::with(['examination_type', 'academic_session'])->find($examinationId);
        if (!$examination) {
            return response()->json(['status' => false, 'message' => ['Examination not found.']], 404);
        }

        // Get all examination_standards (subjects) for this exam + standard
        $examStandards = ExaminationStandard::with(['subject', 'schedules'])
            ->where('examination_id', $examinationId)
            ->where('academic_standard_id', $academicStandardId)
            ->get();

        if ($examStandards->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => ['No subjects found for this examination and standard combination.'],
            ], 404);
        }

        // Build subjects array
        $subjects = $examStandards->map(function ($es) {
            return [
                'id' => $es->id,
                'subject_id' => $es->subject_id,
                'subject_name' => $es->subject?->name ?? 'Unknown',
                'passing_marks' => (float) ($es->passing_marks ?? 0),
                'total_marks' => (float) ($es->total_marks ?? 0),
            ];
        });

        // Get all schedule IDs for these standards
        $scheduleIds = $examStandards->pluck('schedules')->flatten()->pluck('id');

        // Get all active students in this academic standard
        $academicSessionId = $examination->academic_session_id;
        $studentSessions = StudentSession::with(['student', 'section'])
            ->where('academic_standard_id', $academicStandardId)
            ->where('academic_session_id', $academicSessionId)
            ->where('status', 'active')
            ->orderBy('roll_no')
            ->get();

        // Get all results for these students and schedules
        $results = ExaminationResult::with(['examination_schedule'])
            ->whereIn('examination_schedule_id', $scheduleIds)
            ->whereIn('student_id', $studentSessions->pluck('student_id'))
            ->get()
            ->groupBy('student_id');

        // Build student rows: each student has marks per subject
        $students = $studentSessions->map(function ($ss) use ($results, $examStandards) {
            $studentResults = $results->get($ss->student_id, collect());

            // Map results by examination_standard_id (via schedule)
            $marksByStandard = [];
            foreach ($studentResults as $result) {
                $schedule = $result->examination_schedule;
                if ($schedule) {
                    $stdId = $schedule->examination_standard_id;
                    if (!isset($marksByStandard[$stdId])) {
                        $marksByStandard[$stdId] = [
                            'marks_obtained' => (float) ($result->marks_obtained ?? $result->marks ?? 0),
                            'grade' => $result->grade ?? '',
                            'remarks' => $result->remarks ?? '',
                        ];
                    }
                }
            }

            // Build subject marks array
            $subjectMarks = $examStandards->map(function ($es) use ($marksByStandard) {
                $data = $marksByStandard[$es->id] ?? null;
                return [
                    'examination_standard_id' => $es->id,
                    'subject_name' => $es->subject?->name ?? 'Unknown',
                    'marks_obtained' => $data ? $data['marks_obtained'] : null,
                    'grade' => $data ? $data['grade'] : null,
                    'remarks' => $data ? $data['remarks'] : null,
                    'passing_marks' => (float) ($es->passing_marks ?? 0),
                    'total_marks' => (float) ($es->total_marks ?? 0),
                ];
            });

            // Calculate totals
            $totalMarksObtained = $subjectMarks->sum('marks_obtained');
            $totalMarks = $subjectMarks->sum('total_marks');
            $totalPassingMarks = $subjectMarks->sum('passing_marks');
            $percentage = $totalMarks > 0 ? round(($totalMarksObtained / $totalMarks) * 100, 2) : 0;

            // Determine overall grade/pass-fail
            $failedSubjects = $subjectMarks->filter(function ($sm) {
                return $sm['marks_obtained'] !== null && $sm['marks_obtained'] < $sm['passing_marks'];
            });
            $overallStatus = $failedSubjects->count() > 0 ? 'FAIL' : 'PASS';
            $overallGrade = $this->calculateGrade($percentage);

            return [
                'student_id' => $ss->student_id,
                'student_name' => $ss->student?->name ?? 'Unknown',
                'roll_no' => $ss->roll_no,
                'section' => $ss->section?->name ?? '',
                'subject_marks' => $subjectMarks,
                'total_marks_obtained' => $totalMarksObtained,
                'total_marks' => $totalMarks,
                'total_passing_marks' => $totalPassingMarks,
                'percentage' => $percentage,
                'grade' => $overallGrade,
                'status' => $overallStatus,
                'failed_subjects' => $failedSubjects->count(),
            ];
        })->sortBy('roll_no')->values();

        return response()->json([
            'data' => [
                'examination' => [
                    'id' => $examination->id,
                    'name' => $examination->name,
                    'examination_type' => $examination->examination_type?->name ?? '',
                    'academic_session' => $examination->academic_session?->session ?? '',
                ],
                'subjects' => $subjects,
                'students' => $students,
                'summary' => [
                    'total_subjects' => $subjects->count(),
                    'total_students' => $students->count(),
                    'passed' => $students->where('status', 'PASS')->count(),
                    'failed' => $students->where('status', 'FAIL')->count(),
                ],
            ],
        ], 200);
    }

    private function calculateGrade(float $percentage): string
    {
        return match (true) {
            $percentage >= 90 => 'A+',
            $percentage >= 80 => 'A',
            $percentage >= 70 => 'B+',
            $percentage >= 60 => 'B',
            $percentage >= 50 => 'C+',
            $percentage >= 40 => 'C',
            $percentage >= 33 => 'D',
            default => 'F',
        };
    }
    /**
     * Display a listing of the resource.
     */
    public function daily_collection_report(Request $request)
    {
        $message = [];

        $fees = Fee::with(
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
            'campus.school.logo_image'
        )
            ->whereBetween('fee_date', [$request->input('from'), $request->input('to')])
            ->orderBy('id', 'desc')
            ->get();

        $formattedFees = $fees->map(function ($fee) {
            $feeItems = $fee->fee_items->filter(function ($item) {
                return $item->amount > 0;
            })->map(function ($item) {
                return [
                    'fee_head_id' => $item->fee_head->id,
                    'fee_head_name' => $item->fee_head->name,
                    'total_amount' => $item->total_amount
                ];
            });

            $totalAmount = $fee->fee_items->sum('total_amount');

            return [
                'fee_date' => $fee->fee_date,
                'id' => $fee->id,
                'student_id' => $fee->student_id,
                'fee_no' => $fee->fee_no,
                'name' => $fee->student->name,
                'class' => $fee->student_session->academic_class->name,
                'section' => $fee->student_session->section->name,
                'roll_no' => $fee->student_session->roll_no,
                'fee_items' => $feeItems,
                'total' => $totalAmount,
            ];
        });
        return response()->json(["data" => $formattedFees], 200);
        // return new FeeCollection($fees);
    }
    public function monthly_fee_collection_report(Request $request)
    {
        $academicSessionId = $this->getAcademicSessionId($request);

        if (!$academicSessionId) {
            return response()->json(
                [
                    'status' => false,
                    'message' => ['Please configure your academic session first.'],
                ],
                400
            );
        }

        $feesQuery = Fee::with([
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
            'campus.school.logo_image'
        ])
            ->where('academic_session_id', $academicSessionId)
            ->where('is_deleted', '!=', 1); // Exclude soft-deleted fees
        if ($request->has('academic_class_id')) {
            $feesQuery->whereHas('student_session', function ($query) use ($request) {
                $query->where('academic_class_id', $request->academic_class_id);
            });
        }
        if ($request->has('section_id')) {
            $feesQuery->whereHas('student_session', function ($query) use ($request) {
                $query->where('section_id', $request->section_id);
            });
        }
        $fees = $feesQuery->get();
        // Fetch all months
        $months = Month::all();

        // Initialize the collection structure
        $reportData = [];
        $students = [];

        foreach ($fees as $fee) {
            $student = $fee->student;
            $studentSession = $fee->student_session;
            $feeItems = $fee->fee_items;

            // Check if the student is already processed
            if (!array_key_exists($student->id, $students)) {
                // Initialize student data
                $students[$student->id] = [
                    'id' => $student->id,
                    'class' => $studentSession->academic_class->name,
                    'roll_no' => $studentSession->roll_no, // Assuming this is correct
                    'section' => $studentSession->section->name, // Assuming this is correct
                    'session' => $studentSession->academic_session->session, // Assuming this is correct
                    'student_name' => $student->name,
                    'months' => [], // Initialize months as an array
                ];

                // Populate months array with dynamic month headers
                foreach ($months as $month) {
                    // Initialize month data structure
                    $students[$student->id]['months'][] = [
                        'id' => $month->id,
                        'name' => $month->name,
                        'short_name' => strtolower(substr($month->name, 0, 3)),
                        'fee_no' => null,
                        'fee_date' => null,
                        'amount' => 0,
                    ];
                }
            }

            // Process fee items for the student
            foreach ($feeItems as $item) {
                foreach ($item->fee_item_months as $itemMonth) {
                    $monthId = $itemMonth->month->id;
                    // Find the corresponding month in the student's months array
                    foreach ($students[$student->id]['months'] as &$monthData) {
                        if ($monthData['id'] == $monthId) {
                            // Populate month data for the fee items
                            $monthData['fee_id'] = $fee->id;
                            $monthData['fee_no'] = $fee->fee_no;
                            $monthData['fee_date'] = $fee->fee_date;
                            $monthData['amount'] = $itemMonth->amount;
                            break;
                        }
                    }
                }
            }
        }

        // Convert the students associative array to an indexed array for JSON response
        $reportData = array_values($students);
        // order by roll_no
        usort($reportData, function ($a, $b) {
            return $a['roll_no'] <=> $b['roll_no'];
        });

        // Return the data in a JSON response
        return response()->json(['data' => $reportData]);
    }
    public function exam_fees_collection_report(Request $request)
    {
        $academicSessionId = $this->getAcademicSessionId($request);

        if (!$academicSessionId) {
            return response()->json(
                [
                    'status' => false,
                    'message' => ['Please configure your academic session first.'],
                ],
                400
            );
        }
        // 'fee_template',
        // 'academic_session',
        // 'student',
        // 'academic_class',
        // 'campus',
        // 'student_session',
        // 'student_session.campus',
        // 'student_session.academic_class',
        // 'student_session.academic_session',
        // 'student_session.section',
        // 'fee_items',
        $resource = [
            'fee_items.fee_head',
        ];

        $feesQuery = Fee::with($resource)
            ->where('academic_session_id', $academicSessionId)
            ->where('is_deleted', '!=', 1); // Exclude soft-deleted fees;
        if ($request->has('academic_class_id')) {
            $feesQuery->whereHas('student_session', function ($query) use ($request) {
                $query->where('academic_class_id', $request->academic_class_id);
            });
        }
        if ($request->has('section_id')) {
            $feesQuery->whereHas('student_session', function ($query) use ($request) {
                $query->where('section_id', $request->section_id);
            });
        }
        $fees = $feesQuery->get();
        //dump('Total Fees Fetched: ' . $fees->count());

        // Initialize the collection structure
        $reportData = [];
        $students = [];

        foreach ($fees as $fee) {
            $student = $fee->student;
            $studentSession = $fee->student_session;
            $feeItems = $fee->fee_items;
            // dump(!array_key_exists($student->id, $students));

            // Check if the student is already processed
            if (!array_key_exists($student->id, $students)) {
                if ($student->id === 11900 && $fee->id === 24952) {
                    dump($feeItems->toArray());
                }
                // Initialize student data
                $students[$student->id] = [
                    'id' => $student->id,
                    'class' => $studentSession->academic_class->name,
                    'roll_no' => $studentSession->roll_no, // Assuming this is correct
                    'section' => $studentSession->section->name, // Assuming this is correct
                    'session' => $studentSession->academic_session->session, // Assuming this is correct
                    'student_name' => $student->name,
                    'examFees' => [], // Initialize months as an array
                ];
                // if ($student->id === 11900) {
                //     dump($fee->toArray());
                // }
                // if feesItem has fee_head of type exam then populate examFees array

            }
            foreach ($feeItems as $item) {

                // dump($item->fee_head_id);
                if ($item->fee_head_id === 10383) {
                    $students[$student->id]['examFees'][] = [
                        'fee_id' => $fee->id,
                        'fee_no' => $fee->fee_no,
                        'fee_head_name' => $item->fee_head->name,
                        'fee_date' => $fee->fee_date,
                        'amount' => $item->total_amount,
                    ];
                }

            }


        }

        // Convert the students associative array to an indexed array for JSON response
        $reportData = array_values($students);
        // order by roll_no
        usort($reportData, function ($a, $b) {
            return $a['roll_no'] <=> $b['roll_no'];
        });

        // Return the data in a JSON response
        return response()->json(['data' => $reportData]);
    }

    public function FeesByStudentSession(StudentSession $studentSession)
    {

        // $fees = Fee::with('fee_template', 'academic_session', 'student', 'academic_class', 'campus',
        //     'student_session', 'student_session.campus', 'student_session.academic_class',
        //     'student_session.academic_session', 'student_session.section',
        //     'student_session.fee_item_months',
        //     'fee_items',
        //      'fee_items.fee_head',
        //      'fee_items.fee_item_months',
        //      'fee_items.fee_item_months.month',
        //     'campus', 'campus.school', 'campus.school.address', 'campus.school.logo_image')
        //     ->where('student_id', $studentSession->student_id)
        //     ->where('academic_session_id', $studentSession->academic_session_id)
        //     ->orderBy('id', 'desc')
        //     ->get();
        $fees = Fee::with([
            'fee_template',
            'academic_session',
            'student',
            'academic_class',
            'campus',
            'student_session' => function ($query) {
                $query->with([
                    'campus',
                    'academic_class',
                    'academic_session',
                    'section',
                    'fee_item_months' => function ($query) {
                        $query->where('is_deleted', '!=', 1)->with(['month']);
                    },
                ]);
            },
            'fee_items' => function ($query) {
                $query->where('is_deleted', '!=', 1)
                    ->with([
                        'fee_head',
                        'fee_item_months' => function ($query) {
                            $query->where('is_deleted', '!=', 1)->with(['month']);
                        }
                    ]);
            },
            'campus.school',
            'campus.school.address',
            'campus.school.logo_image',
        ])
            ->where('is_deleted', '!=', 1) // Apply is_deleted condition to the main fees table
            ->where('student_id', $studentSession->student_id)
            ->where('academic_session_id', $studentSession->academic_session_id)
            ->orderBy('id', 'desc')
            ->get();
        return new FeeCollection($fees);
    }

    public function show(Fee $fee)
    {
        $fee = Fee::with(
            'fee_template',
            'academic_session',
            'student',
            'academic_class',
            'campus',
            'fee_items',
            'fee_items.fee_head',
            'campus.school',
            'campus.school.address',
            'campus.school.logo_image'
        )->find($fee->id);
        return new FeeResource($fee);
    }

    /**
     * Update the specified resource in storage.
     */

}
