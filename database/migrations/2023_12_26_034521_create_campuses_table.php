<?php

use App\Models\School;
use App\Models\Address;
use App\Enums\RoomTypeEnum;
use App\Models\Document;
use App\Models\EducationBoard;
use Illuminate\Support\Facades\Schema;
use Database\Factories\RoomTypeFactory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campuses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(School::class)->nullable();
            $table->foreignIdFor(EducationBoard::class)->nullable();
            $table->string('name')->require()->unique();
            $table->string('code')->nullable();
            $table->foreignIdFor(Address::class)->nullable();
            $table->string('contact_no')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->date('establishment_date')->nullable();
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->unsignedBigInteger('logo_image_id')->nullable();
            // $table->string('logo_image')->default(value:'/images/default_logo.png');
            $table->timestamps();
        });

        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->string('code')->nullable();
            $table->foreignId(column:'campus_id')
                    ->constrained(table:'campuses')
                    ->onDelete(action:'cascade');
            $table->integer('capacity')->nullable();
            $table->timestamps();
        });
        Schema::create('floors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->string('code')->nullable();
            $table->foreignId(column:'building_id')
                    ->constrained(table:'buildings')
                    ->onDelete(action:'cascade');
            $table->integer('capacity')->nullable();
            $table->timestamps();
        });
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->string('code')->nullable();
            $table->foreignId(column:'floor_id')
            ->constrained(table:'floors')
            ->onDelete(action:'cascade');
            $table->integer('capacity')->nullable();
            $table->boolean('is_available')->default(value:true);
            $table->enum('room_type',array_keys(RoomTypeEnum::labels()))->default(RoomTypeEnum::default());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campuses');
        Schema::dropIfExists('buildings');
        Schema::dropIfExists('floors');
        Schema::dropIfExists('rooms');
    }
};
