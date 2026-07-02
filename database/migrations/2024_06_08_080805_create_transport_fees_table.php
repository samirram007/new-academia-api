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
        Schema::create('transport_fees', function (Blueprint $table) {
            $table->id();
            $table->string('fee_no');
            $table->date('fee_date');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('campus_id');
            $table->unsignedBigInteger('academic_session_id');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->decimal('balance_amount', 10, 2)->nullable();
            $table->string('payment_mode')->nullable();
            $table->timestamps();
        });
        Schema::create('transport_fee_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transport_fee_id');
            $table->unsignedBigInteger('fee_head_id');
            $table->integer('quantity')->default(1);
            $table->string('months')->nullable(); // comma separated months e.g., Jan-Feb-Mar
            $table->decimal('amount', 10, 2);
            $table->boolean('is_deleted')->default(false);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });
        Schema::create('transport_fee_item_months', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transport_fee_item_id');
            $table->unsignedBigInteger('academic_session_id');
            $table->unsignedBigInteger('month_id');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_fees');
    }
};
