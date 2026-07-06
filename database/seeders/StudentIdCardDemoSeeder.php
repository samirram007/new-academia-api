<?php

namespace Database\Seeders;

use App\Models\StudentSession;
use Illuminate\Database\Seeder;

class StudentIdCardDemoSeeder extends Seeder
{
    public function run(): void
    {
        $totalSessions = StudentSession::count();

        if ($totalSessions === 0) {
            $this->command->warn('No student sessions found. Skipping ID card demo seed.');
            return;
        }

        // Pick 10% of student sessions across different classes and mark them as printable
        $targetCount = (int) ceil($totalSessions * 0.1);
        $updatedCount = 0;

        // Get distinct (academic_class_id, campus_id) groupings
        $grouped = StudentSession::select('academic_class_id', 'campus_id')
            ->whereNotNull('academic_class_id')
            ->whereNotNull('campus_id')
            ->distinct()
            ->get();

        if ($grouped->isEmpty()) {
            $this->command->warn('No class/campus groupings found. Falling back to random selection.');
            StudentSession::inRandomOrder()->limit($targetCount)->update([
                'is_idcard_printable' => true,
                'idcard_print_count' => rand(1, 5),
            ]);
            $updatedCount = $targetCount;
        } else {
            // Distribute the printable sessions evenly across class/campus groups
            $perGroup = max(1, (int) ceil($targetCount / $grouped->count()));

            foreach ($grouped as $group) {
                $sessions = StudentSession::where('academic_class_id', $group->academic_class_id)
                    ->where('campus_id', $group->campus_id)
                    ->inRandomOrder()
                    ->limit($perGroup)
                    ->get();

                foreach ($sessions as $session) {
                    $session->is_idcard_printable = true;
                    $session->idcard_print_count = rand(0, 10);
                    $session->save();
                    $updatedCount++;
                }
            }
        }

        $this->command->info(sprintf(
            'Seeded: %d student sessions marked as ID card printable (out of %d total)',
            $updatedCount,
            $totalSessions
        ));
    }
}
