<?php

namespace Database\Seeders;

use App\Models\Promotion;
use App\Models\User;
use App\Models\AcademicSession;
use App\Models\AcademicClass;
use App\Models\Campus;
use App\Models\StudentSession;
use Illuminate\Database\Seeder;

class PromotionsDemoSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('user_type', 'student')->get();
        $sessions = AcademicSession::all();
        $classes = AcademicClass::all();
        $campuses = Campus::all();

        if ($students->isEmpty() || $sessions->count() < 2 || $classes->isEmpty()) {
            $this->command->warn('Not enough data. Need students, 2+ sessions, and classes. Skipping promotion demo seed.');
            return;
        }

        // Sort sessions by ID so we can pick consecutive pairs (old → new)
        $sortedSessions = $sessions->sortBy('id')->values();

        $promotionNoCounter = 1;
        $createdCount = 0;

        // Pick 3 session pairs (0→1, 2→3, 4→5) to create promotion batches
        for ($pairIdx = 0; $pairIdx < min(3, (int) floor($sortedSessions->count() / 2)); $pairIdx++) {
            $oldSession = $sortedSessions[$pairIdx * 2];
            $newSession = $sortedSessions[$pairIdx * 2 + 1];

            // Pick a batch of students (staggered per pair)
            $batchStudents = $students->slice($pairIdx * 80, 80);

            foreach ($batchStudents as $student) {
                // Find their old student session for this session
                $oldStudentSession = StudentSession::where('student_id', $student->id)
                    ->where('academic_session_id', $oldSession->id)
                    ->first();

                // Pick a random old class (or from their existing session)
                $oldClass = $oldStudentSession
                    ? ($classes->firstWhere('id', $oldStudentSession->academic_class_id) ?? $classes->random())
                    : $classes->random();

                // Pick a different class as the promoted one
                $newClass = $classes->where('id', '!=', $oldClass->id)->random();
                $oldCampus = $campuses->random();
                $otherCampuses = $campuses->where('id', '!=', $oldCampus->id);
                $newCampus = $otherCampuses->isNotEmpty() ? $otherCampuses->random() : $campuses->random();

                // Generate a promotion date near the session boundary
                $promotionDate = date('Y-m-d', strtotime("{$newSession->session}-06-01 +{$pairIdx} days"));

                Promotion::create([
                    'promotion_no' => sprintf('PROMO-%04d', $promotionNoCounter++),
                    'promotion_date' => $promotionDate,
                    'student_id' => $student->id,
                    'old_student_session_id' => $oldStudentSession?->id,
                    'old_academic_session_id' => $oldSession->id,
                    'old_academic_class_id' => $oldClass->id,
                    'old_academic_standard_id' => $oldClass->academic_standard_id,
                    'old_campus_id' => $oldCampus->id,
                    'new_academic_session_id' => $newSession->id,
                    'new_academic_class_id' => $newClass->id,
                    'new_academic_standard_id' => $newClass->academic_standard_id,
                    'new_campus_id' => $newCampus->id,
                    'is_active' => true,
                ]);

                $createdCount++;
            }
        }

        $this->command->info(sprintf(
            'Seeded: %d promotion records across %d session pairs',
            $createdCount,
            min(3, (int) floor($sortedSessions->count() / 2))
        ));
    }
}
