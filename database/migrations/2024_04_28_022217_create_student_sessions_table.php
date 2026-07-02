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
        Schema::create('student_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('academic_session_id');
            $table->unsignedBigInteger('campus_id');
            $table->unsignedBigInteger('academic_class_id');
            $table->unsignedBigInteger('academic_standard_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->integer('roll_no')->nullable();
            $table->unsignedBigInteger('status');
            $table->boolean('is_promoted')->default(false);
            $table->unsignedBigInteger('previous_student_session_id')->nullable();
            $table->unsignedBigInteger('next_student_session_id')->nullable();
            $table->boolean('is_idcard_printable')->default(false);
            $table->integer('idcard_print_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_sessions');
    }
};
