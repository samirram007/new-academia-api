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
        Schema::create('transport_maintenances', function (Blueprint $table) {
            $table->id();
            $table->date('transport_maintenance_date')->nullable();
            $table->date('repaired_date')->nullable();
            $table->text('reason')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_maintainances');
    }
};
