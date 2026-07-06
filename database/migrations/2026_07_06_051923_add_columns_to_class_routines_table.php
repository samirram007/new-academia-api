<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('class_routines', function (Blueprint $table) {
            $table->string('day_of_week');
            $table->unsignedBigInteger('academic_session_id');
            $table->unsignedBigInteger('academic_class_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->time('start_time');
            $table->time('end_time');

            $table->foreign('academic_session_id')->references('id')->on('academic_sessions');
            $table->foreign('academic_class_id')->references('id')->on('academic_classes');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('teacher_id')->references('id')->on('users');
            $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    public function down(): void
    {
        Schema::table('class_routines', function (Blueprint $table) {
            $table->dropForeign(['academic_session_id']);
            $table->dropForeign(['academic_class_id']);
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['room_id']);
            $table->dropColumn([
                'day_of_week',
                'academic_session_id',
                'academic_class_id',
                'subject_id',
                'teacher_id',
                'room_id',
                'start_time',
                'end_time',
            ]);
        });
    }
};
