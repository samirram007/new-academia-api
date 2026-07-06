<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('examination_types', function (Blueprint $table) {
            if (!Schema::hasColumn('examination_types', 'code')) {
                $table->string('code', 50)->nullable()->after('name');
            }
            if (!Schema::hasColumn('examination_types', 'description')) {
                $table->text('description')->nullable()->after('is_promotional_exam');
            }
        });
    }

    public function down(): void
    {
        Schema::table('examination_types', function (Blueprint $table) {
            $table->dropColumn(['code', 'description']);
        });
    }
};
