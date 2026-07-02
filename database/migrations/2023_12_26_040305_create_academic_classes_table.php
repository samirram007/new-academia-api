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
        Schema::create('academic_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->string('code')->nullable();
            $table->foreignId(column:'campus_id')
            ->constrained(table:'campuses');
            $table->foreignId(column:'academic_standard_id')
            ->constrained(table:'academic_standards');
            $table->foreignId(column:'section_id')
            ->constrained(table:'sections');
            $table->integer('capacity')->default(50);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_classes');
    }
};
