<?php

use App\Models\Campus;
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
        Schema::create('academic_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Campus::class)->default(1);
            $table->string('session');
            $table->date('start_date');
            $table->date('end_date');
            $table->bigInteger('previous_academic_session_id')->nullable();
            $table->bigInteger('next_academic_session_id')->nullable();
            $table->integer('current_fee_no')->default(1);
            $table->integer('current_expense_no')->default(1);
            $table->integer('current_transport_expense_no')->default(1);
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_sessions');
    }
};
