<?php

namespace Database\Seeders;

use App\Models\ExaminationType;
use App\Models\Examination;
use App\Models\ExaminationStandard;
use App\Models\ExaminationSchedule;
use App\Models\ExaminationResult;
use App\Models\AcademicSession;
use App\Models\AcademicStandard;
use App\Models\Subject;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Seeder;

class ExaminationDemoSeeder extends Seeder
{
    public function run(): void
    {
        $sessions = AcademicSession::all();
        if ($sessions->isEmpty()) {
            $this->command->warn('No academic sessions found. Skipping examination demo seed.');
            return;
        }

        $standards = AcademicStandard::all();
        $subjects = Subject::all();
        $students = User::where('user_type', 'student')->get();
        $teachers = User::where('user_type', 'teacher')->get();
        $rooms = Room::all();

        if ($standards->isEmpty() || $subjects->isEmpty()) {
            $this->command->warn('No standards or subjects found. Skipping examination demo seed.');
            return;
        }

        // ─── Examination Types ───────────────────────────────────────
        $examTypes = [
            ['name' => 'Midterm Examination', 'code' => 'MID', 'description' => 'Mid-term assessment', 'is_promotional_exam' => false],
            ['name' => 'Final Examination', 'code' => 'FIN', 'description' => 'End-of-term final exam', 'is_promotional_exam' => true],
            ['name' => 'Quarterly Examination', 'code' => 'QRT', 'description' => 'Quarterly progress test', 'is_promotional_exam' => false],
            ['name' => 'Half-Yearly Examination', 'code' => 'HALF', 'description' => 'Half-yearly assessment', 'is_promotional_exam' => false],
            ['name' => 'Weekly Test', 'code' => 'WEEK', 'description' => 'Weekly class test', 'is_promotional_exam' => false],
        ];

        foreach ($examTypes as $type) {
            ExaminationType::firstOrCreate(['name' => $type['name']], $type);
        }

        $allExamTypes = ExaminationType::all();

        // ─── Examinations per session ───────────────────────────────
        $examNames = [
            'Weekly Test 1', 'Weekly Test 2', 'Quarterly Exam',
            'Half-Yearly Exam', 'Weekly Test 3', 'Weekly Test 4',
            'Midterm Exam', 'Pre-Final Exam', 'Final Exam',
        ];

        foreach ($sessions as $session) {
            foreach ($examNames as $i => $name) {
                $type = $allExamTypes->random();
                $year = substr($session->session, 0, 4);
                $month = str_pad((string)(($i % 12) + 1), 2, '0', STR_PAD_LEFT);

                $uniqueName = $name . ' (' . $session->session . ')';
                Examination::firstOrCreate(
                    ['name' => $uniqueName, 'academic_session_id' => $session->id],
                    [
                        'code' => strtoupper(substr(str_replace(' ', '_', $name), 0, 6) . '_' . $session->id),
                        'examination_type_id' => $type->id,
                        'academic_session_id' => $session->id,
                        'examination_start_date' => "{$year}-{$month}-10",
                        'examination_end_date' => "{$year}-{$month}-20",
                        'description' => "{$name} for session {$session->session}",
                    ]
                );
            }
        }

        $examinations = Examination::all();

        // ─── Examination Standards (per exam, per standard, per subject) ──
        foreach ($examinations as $exam) {
            foreach ($standards as $standard) {
                $relevantSubjects = $subjects->take(rand(2, 5));
                foreach ($relevantSubjects as $subject) {
                    $total = rand(50, 100);
                    $passing = (int) round($total * 0.35);
                    ExaminationStandard::firstOrCreate(
                        [
                            'examination_id' => $exam->id,
                            'academic_standard_id' => $standard->id,
                            'subject_id' => $subject->id,
                        ],
                        [
                            'passing_marks' => $passing,
                            'total_marks' => $total,
                        ]
                    );
                }
            }
        }

        $examStandards = ExaminationStandard::all();

        // ─── Examination Schedules ──────────────────────────────────
        foreach ($examStandards as $es) {
            $exam = $examinations->find($es->examination_id);
            if (!$exam) continue;

            $examDate = $exam->examination_start_date
                ? date('Y-m-d', strtotime($exam->examination_start_date . ' + ' . rand(0, 10) . ' days'))
                : now()->addDays(rand(1, 30))->format('Y-m-d');

            $startTime = sprintf('%02d:00:00', rand(8, 12));
            $endTime = sprintf('%02d:00:00', rand(13, 16));
            ExaminationSchedule::firstOrCreate(
                [
                    'examination_standard_id' => $es->id,
                    'subject_id' => $es->subject_id,
                ],
                [
                    'teacher_id' => $teachers->isNotEmpty() ? $teachers->random()->id : null,
                    'examination_date' => $examDate,
                    'examination_time' => $startTime,
                    'exam_date' => $examDate,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'room_id' => $rooms->isNotEmpty() ? $rooms->random()->id : null,
                ]
            );
        }

        $schedules = ExaminationSchedule::all();

        // ─── Examination Results ────────────────────────────────────
        if ($students->isNotEmpty()) {
            foreach ($schedules as $schedule) {
                $es = $examStandards->find($schedule->examination_standard_id);
                $studentsForClass = $students;

                foreach ($studentsForClass as $student) {
                    $totalMarks = $es?->total_marks ?? 100;
                    $passingMarks = $es?->passing_marks ?? 35;
                    $marksObtained = rand(0, (int) $totalMarks);

                    $grade = $marksObtained >= ($totalMarks * 0.9) ? 'A+' :
                        ($marksObtained >= ($totalMarks * 0.8) ? 'A' :
                        ($marksObtained >= ($totalMarks * 0.7) ? 'B+' :
                        ($marksObtained >= ($totalMarks * 0.6) ? 'B' :
                        ($marksObtained >= ($totalMarks * 0.5) ? 'C' :
                        ($marksObtained >= $passingMarks ? 'D' : 'F')))));

                    ExaminationResult::firstOrCreate(
                        [
                            'examination_schedule_id' => $schedule->id,
                            'student_id' => $student->id,
                        ],
                        [
                            'examination_scheduled_id' => $schedule->id,
                            'marks' => (string) $marksObtained,
                            'marks_obtained' => $marksObtained,
                            'grade' => $grade,
                            'remarks' => $marksObtained >= $passingMarks ? 'Passed' : 'Failed',
                        ]
                    );
                }
            }
        }

        $this->command->info(sprintf(
            'Seeded: %d exam types, %d exams, %d exam standards, %d schedules, %d results',
            $allExamTypes->count(),
            $examinations->count(),
            $examStandards->count(),
            $schedules->count(),
            ExaminationResult::count()
        ));
    }
}
