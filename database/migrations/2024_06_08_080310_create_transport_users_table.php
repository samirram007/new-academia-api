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
        Schema::create('transport_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('student_session_id')->nullable();
            $table->date('join_date')->nullable();
            $table->date('dissociate_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('transport_id');
            $table->unsignedBigInteger('pickup_slot_id')->nullable();
            $table->unsignedBigInteger('drop_slot_id')->nullable();
            $table->unsignedBigInteger('pickup_point_id')->nullable();
            $table->unsignedBigInteger('drop_point_id')->nullable();
            $table->time('pickup_time')->nullable();
            $table->time('drop_time')->nullable();
            $table->unsignedBigInteger('journey_type_id')->nullable();
            $table->boolean('is_free')->default(false);
            $table->boolean('monthly_charge')->default(false);
            $table->boolean('is_idcard_printable')->default(false);
            $table->integer('idcard_print_count')->default(0);
            $table->boolean('is_release_idcard_printable')->default(false);
            $table->integer('release_idcard_print_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_users');
    }
};
