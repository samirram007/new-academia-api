<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // examination_schedules: old examination_time column
        Schema::table('examination_schedules', function (Blueprint $table) {
            $table->time('examination_time')->nullable()->change();
        });

        // examination_results: old examination_scheduled_id and marks columns
        Schema::table('examination_results', function (Blueprint $table) {
            $table->unsignedBigInteger('examination_scheduled_id')->nullable()->change();
            $table->string('marks')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('examination_schedules', function (Blueprint $table) {
            $table->time('examination_time')->nullable(false)->change();
        });

        Schema::table('examination_results', function (Blueprint $table) {
            $table->unsignedBigInteger('examination_scheduled_id')->nullable(false)->change();
            $table->string('marks')->nullable(false)->change();
        });
    }
};
