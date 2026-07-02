<?php

use App\Models\User;
use App\Models\State;
use App\Models\Address;
use App\Models\Country;
use App\Enums\GenderEnum;
use App\Enums\UserTypeEnum;
use App\Enums\UserStatusEnum;
use App\Enums\AddressTypeEnum;
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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->string('country_code')->nullable();
            $table->timestamps();
        });
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->string('state_code')->nullable();
            $table->foreignIdFor(Country::class)->default(1);
            $table->timestamps();
        });

        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->timestamps();
        });
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable();
            $table->enum('address_type',AddressTypeEnum::labels())->default(AddressTypeEnum::default());
            $table->string('house_no')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('village')->nullable();
            $table->string('post_office')->nullable();
            $table->string('rail_station')->nullable();
            $table->string('police_station')->nullable();
            $table->string('district')->nullable();
            $table->foreignIdFor(State::class)->nullable();
            $table->foreignIdFor(Country::class)->nullable();
            $table->string('pincode')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('designations');
        Schema::dropIfExists('departments');

    }
};