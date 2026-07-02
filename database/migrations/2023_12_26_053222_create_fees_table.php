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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('fee_no');
            $table->date('fee_date');
            $table->unsignedBigInteger('fee_template_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('academic_session_id');
            $table->unsignedBigInteger('academic_class_id');
            $table->unsignedBigInteger('campus_id');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->decimal('balance_amount', 10, 2)->nullable();
            $table->string('payment_mode')->nullable();
            // $table->foreign('fee_template_id')->references('id')->on('fee_templates');
            // $table->foreign('student_id')->references('id')->on('users');
            $table->timestamps();
        });
        Schema::create('fee_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fee_id');
            $table->unsignedBigInteger('fee_head_id');
            $table->integer('quantity')->default(1);
            $table->string('months')->nullable(); // comma separated months e.g., Jan-Feb-Mar
            $table->decimal('amount', 10, 2);
            $table->boolean('is_customizable')->default(false);
            $table->boolean('keep_periodic_details')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });
        Schema::create('fee_item_months', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fee_item_id');
            $table->unsignedBigInteger('student_session_id');
            $table->unsignedBigInteger('month_id');
            $table->decimal('amount', 10, 2);
            // $table->foreign('fee_item_id')->references('id')->on('fee_items');
            $table->timestamps();
        });
        Schema::create('fee_receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paid_by_user_id');
            $table->date('receipt_date');
            $table->decimal('amount', 10, 2);
            $table->string('payment_mode')->nullable();
            $table->string('receipt_no')->nullable();
            $table->string('receipt_note')->nullable();
            $table->boolean('is_system_receipt')->default(true);
            $table->timestamp('system_receipt_date')->nullable();
            // $table->foreign('paid_by_user_id')->references('id')->on('users');
            $table->timestamps();
        });
        //fee and fee receipts has many to many relationship
        Schema::create('fee_fee_receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fee_id');
            $table->unsignedBigInteger('fee_receipt_id');
            // $table->foreign('fee_id')->references('id')->on('fees');
            // $table->foreign('fee_receipt_id')->references('id')->on('fee_receipts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_fees_receipts');
        Schema::dropIfExists('fee_receipts');
        Schema::dropIfExists('fee_item_months');
        Schema::dropIfExists('fee_items');
        Schema::dropIfExists('fees');
    }
};
