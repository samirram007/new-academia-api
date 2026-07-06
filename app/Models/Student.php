<?php

namespace App\Models;

use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Model;


class Student extends Model
{

    protected $table = 'students'; //is view of user_type student
    protected $fillable = [
        'id',
        'name',
        'username',
        'user_type',
        'code',
        'emergency_contact_name',
        'emergency_contact_no',
        'birth_mark',
        'medical_conditions',
        'allergies',
        'nationality',
        'religion',
        'caste',
        'language',
        'guardian_type',
        'address_id',
        'designation_id',
        'department_id',
        'doj',
        'dob',
        'aadhaar_no',
        'pan_no',
        'passport_no',
        'profile_document_id',
        'bank_name',
        'account_holder_name',
        'bank_ifsc',
        'bank_branch',

        'admission_no',
        'admission_date',
        'campus_id',
        'academic_session_id',
        'academic_class_id',

        'education',
        'occupation',

    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'admission_date' => 'date',
        'dob' => 'date',
        'doj' => 'date',
        'admission_date' => 'date',

        'password' => 'hashed',
        'user_type' => UserTypeEnum::class,
        'status' => UserStatusEnum::class,
        'profile_document_id' => 'integer',
    ];

    public function profile_document()
    {
        return $this->belongsTo(Document::class, 'profile_document_id');
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    public function student_sessions()
    {
        return $this->hasMany(StudentSession::class, 'student_id', 'id');
    }
}
