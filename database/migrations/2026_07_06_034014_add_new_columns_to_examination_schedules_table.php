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
        Schema::table('examination_schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('examination_schedules', 'exam_date')) {
                $table->date('exam_date')->nullable()->after('teacher_id');
            }
            if (!Schema::hasColumn('examination_schedules', 'start_time')) {
                $table->time('start_time')->nullable()->after('exam_date');
            }
            if (!Schema::hasColumn('examination_schedules', 'end_time')) {
                $table->time('end_time')->nullable()->after('start_time');
            }
            if (!Schema::hasColumn('examination_schedules', 'room_id')) {
                $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete()->after('end_time');
            }
        });
    }

    public function down(): void
    {
        Schema::table('examination_schedules', function (Blueprint $table) {
            $table->dropColumn(['exam_date', 'start_time', 'end_time', 'room_id']);
        });
    }
};
