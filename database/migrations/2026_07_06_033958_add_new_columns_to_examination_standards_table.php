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
        Schema::table('examination_standards', function (Blueprint $table) {
            if (!Schema::hasColumn('examination_standards', 'subject_id')) {
                $table->foreignId('subject_id')->nullable()->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('examination_standards', 'passing_marks')) {
                $table->decimal('passing_marks', 8, 2)->nullable();
            }
            if (!Schema::hasColumn('examination_standards', 'total_marks')) {
                $table->decimal('total_marks', 8, 2)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('examination_standards', function (Blueprint $table) {
            $table->dropColumn(['subject_id', 'passing_marks', 'total_marks']);
        });
    }
};
