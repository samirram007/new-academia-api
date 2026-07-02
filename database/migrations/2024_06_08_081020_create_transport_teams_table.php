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
        Schema::create('transport_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transport_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('team_role_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_teams');
    }
};
