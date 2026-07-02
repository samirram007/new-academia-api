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
        Schema::create('transport_insurances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transport_id');
            $table->unsignedBigInteger('document_id')->nullable();
            $table->string('insurance_no')->nullable();
            $table->date('insurance_date')->nullable();
            $table->date('insurance_valid_date')->nullable();
            $table->date('renewal_date')->nullable();
            $table->integer('insured_value')->default(50);
            $table->integer('purchase_cost')->default(50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_insurances');
    }
};
