<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('examination_results', function (Blueprint $table) {
            if (!Schema::hasColumn('examination_results', 'examination_schedule_id')) {
                $table->foreignId('examination_schedule_id')->nullable()->constrained('examination_schedules')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('examination_results', 'marks_obtained')) {
                $table->decimal('marks_obtained', 8, 2)->nullable();
            }
            if (!Schema::hasColumn('examination_results', 'grade')) {
                $table->string('grade', 10)->nullable();
            }
            if (!Schema::hasColumn('examination_results', 'remarks')) {
                $table->text('remarks')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('examination_results', function (Blueprint $table) {
            $table->dropColumn(['examination_schedule_id', 'marks_obtained', 'grade', 'remarks']);
        });
    }
};
