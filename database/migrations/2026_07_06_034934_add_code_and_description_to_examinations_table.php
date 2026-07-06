<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            if (!Schema::hasColumn('examinations', 'code')) {
                $table->string('code', 50)->nullable()->after('name');
            }
            if (!Schema::hasColumn('examinations', 'description')) {
                $table->text('description')->nullable()->after('examination_end_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn(['code', 'description']);
        });
    }
};
