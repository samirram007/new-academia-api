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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('promotion_no')->nullable();
            $table->date('promotion_date')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('old_student_session_id')->nullable();
            $table->unsignedBigInteger('old_campus_id')->nullable();
            $table->unsignedBigInteger('old_academic_session_id')->nullable();
            $table->unsignedBigInteger('old_academic_class_id')->nullable();
            $table->unsignedBigInteger('old_academic_standard_id')->nullable();
            $table->unsignedBigInteger('new_student_session_id')->nullable();
            $table->unsignedBigInteger('new_campus_id')->nullable();
            $table->unsignedBigInteger('new_academic_session_id')->nullable();
            $table->unsignedBigInteger('new_academic_class_id')->nullable();
            $table->unsignedBigInteger('new_academic_standard_id')->nullable();
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
        Schema::dropIfExists('promotions');
    }
};
