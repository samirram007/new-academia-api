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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('admission_no')->nullable();
            $table->date('admission_date')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('campus_id');
            $table->unsignedBigInteger('academic_session_id');
            $table->unsignedBigInteger('academic_class_id');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
