<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('examination_type_id')->constrained(table: 'examination_types')->onDelete(action: 'cascade');
            $table->date('examination_start_date');
            $table->date('examination_end_date');
            $table->foreignId('academic_session_id')->constrained(table: 'academic_sessions')->onDelete(action: 'cascade');
            $table->timestamps();
        });


        Schema::create('examination_standards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_standard_id')->constrained(table: 'academic_standards')->onDelete(action: 'cascade');
            $table->foreignId('examination_id')->constrained(table: 'examinations')->onDelete(action: 'cascade');
            $table->timestamps();
        });

        Schema::create('examination_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examination_standard_id')->constrained(table: 'examination_standards')->onDelete(action: 'cascade');
            $table->foreignId('subject_id')->constrained(table: 'subjects')->onDelete(action: 'cascade');
            $table->date('examination_date');
            $table->time('examination_time');
            $table->foreignId('teacher_id')->constrained(table: 'users')->onDelete(action: 'cascade');
            $table->timestamps();
        });

        Schema::create('examination_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examination_scheduled_id')->constrained(table: 'examination_schedules')->onDelete(action: 'cascade');
            $table->string('marks');
            $table->foreignId('student_id')->constrained(table: 'users')->onDelete(action: 'cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examinations');
        // Schema::dropIfExists('examination_types');
        Schema::dropIfExists('examination_standards');
        Schema::dropIfExists('examination_schedules');
        Schema::dropIfExists('examination_results');
    }
};