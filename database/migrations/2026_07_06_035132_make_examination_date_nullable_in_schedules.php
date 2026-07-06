<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('examination_schedules', function (Blueprint $table) {
            $table->date('examination_date')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('examination_schedules', function (Blueprint $table) {
            $table->date('examination_date')->nullable(false)->change();
        });
    }
};
