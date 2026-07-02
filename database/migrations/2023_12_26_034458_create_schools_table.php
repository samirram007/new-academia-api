<?php

use App\Models\Address;
use App\Models\EducationBoard;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('education_boards', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->string('code')->nullable();
            $table->foreignIdFor(Address::class)->nullable();
            $table->text('description')->nullable();
            $table->string('contact_no')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('website')->unique()->nullable();
            $table->date('establishment_date')->nullable();
            $table->unsignedBigInteger('logo_image_id')->nullable();
            // $table->string('logo_image')->default(value:'/images/default_logo.png');
            $table->timestamps();
        });
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->string('code')->nullable();
            $table->foreignIdFor(EducationBoard::class)->nullable();
            $table->foreignIdFor(Address::class)->nullable();
            $table->string('contact_no')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('website')->nullable();
            $table->date('establishment_date')->nullable();
            $table->foreignId(column:'school_type_id')
                    ->constrained(table:'school_types')
                    ->onDelete(action:'cascade');
                    $table->unsignedBigInteger('logo_image_id')->nullable();
            // $table->string('logo_image')->default(value:'/images/default_logo.png');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_boards');
        Schema::dropIfExists('schools');
    }
};
