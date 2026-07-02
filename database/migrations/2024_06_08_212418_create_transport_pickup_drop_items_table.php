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
        Schema::create('transport_pickup_drop_items', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->unsignedBigInteger('pickup_drop_id')->nullable();
            $table->unsignedBigInteger('pickup_drop_datetime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_pickup_drop_items');
    }
};
