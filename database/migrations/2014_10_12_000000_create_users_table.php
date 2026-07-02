<?php

use App\Enums\CasteEnum;
use App\Models\Address;
use App\Enums\GenderEnum;
use App\Models\Department;
use App\Enums\LanguageEnum;
use App\Enums\UserTypeEnum;
use App\Models\Designation;
use App\Enums\UserStatusEnum;
use App\Enums\NationalityEnum;
use App\Enums\GuardianTypeEnum;
use App\Enums\ReligionEnum;
use App\Models\Campus;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username',10)->unique();
            $table->string('code',50)->nullable();
            $table->enum('user_type',  array_keys(UserTypeEnum::labels()))->default(UserTypeEnum::default());
            $table->string('email',50)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('contact_no',10)->nullable();
            $table->timestamp('contact_no_verified_at')->nullable();
            $table->string('password');
            $table->enum('status',array_keys(UserStatusEnum::labels()))->default(UserStatusEnum::default());
            $table->string('emergency_contact_name',100)->nullable();
            $table->string('emergency_contact_no',10)->nullable();
            $table->string('birth_mark',100)->nullable();
            $table->text('medical_conditions',200)->nullable();
            $table->text('allergies',200)->nullable();
            $table->enum('language',array_keys(LanguageEnum::labels()))->nullable();
            $table->enum('nationality',array_keys(NationalityEnum::labels()))->nullable();
            $table->enum('religion',array_keys(ReligionEnum::labels()))->nullable();
            $table->enum('caste',array_keys(CasteEnum::labels()))->nullable();
            $table->enum('guardian_type',array_keys(GuardianTypeEnum::labels()))->nullable();
            $table->foreignIdFor(Address::class)->nullable();
            $table->foreignIdFor(Department::class)->nullable();
            $table->foreignIdFor(Designation::class)->nullable();
            $table->foreignIdFor(Campus::class)->nullable();
            $table->enum('gender',array_keys(GenderEnum::labels()))->nullable();
            $table->date('doj')->nullable();
            $table->date('dob')->nullable();
            $table->string('dob_log')->nullable();
            $table->string('aadhaar_no',20)->nullable();
            $table->string('pan_no',20)->nullable();
            $table->string('passport_no',50)->nullable();
            $table->unsignedBigInteger('profile_document_id')->constrained('documents')->nullable();
            $table->string('bank_name',100)->nullable();
            $table->string('account_holder_name',100)->nullable();
            $table->string('bank_account_no',20)->nullable();
            $table->string('bank_ifsc',20)->nullable();
            $table->string('bank_branch',100)->nullable();
            $table->string('admission_no',100)->nullable();
            $table->date('admission_date')->nullable();
            $table->string('education',255)->nullable();
            $table->string('occupation',255)->nullable();
            $table->string('earnings',255)->nullable();
            $table->unsignedBigInteger('academic_session_id')->nullable();
            $table->unsignedBigInteger('campus_id')->nullable();
            $table->unsignedBigInteger('academic_class_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('student_guardian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('guardian_id')->constrained('users');
            // Add any additional columns needed for the relationship
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('student_guardian');
    }
};
