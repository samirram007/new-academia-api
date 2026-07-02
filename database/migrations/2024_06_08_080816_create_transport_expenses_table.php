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

        Schema::create('transport_expense_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transport_expense_id');
            $table->unsignedBigInteger('expense_head_id');
            $table->integer('quantity')->default(1);
            $table->string('months')->nullable(); // comma separated months e.g., Jan-Feb-Mar
            $table->decimal('amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });
        Schema::create('transport_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_no');
            $table->string('voucher_no')->nullable();
            $table->date('expense_date');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('academic_session_id');
            $table->unsignedBigInteger('campus_id');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->decimal('balance_amount', 10, 2)->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('narration')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_expenses');
    }
};
