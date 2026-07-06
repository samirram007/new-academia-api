<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable=[
        'promotion_no',
        'promotion_date',
       'student_id',
       'old_student_session_id',
       'old_campus_id',
       'old_academic_session_id',
       'old_academic_class_id',
       'old_academic_standard_id',
       'new_student_session_id',
       'new_campus_id',
       'new_academic_session_id',
       'new_academic_class_id',
       'new_academic_standard_id',
        'is_active',
        'is_deleted'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function oldAcademicSession()
    {
        return $this->belongsTo(AcademicSession::class, 'old_academic_session_id');
    }

    public function newAcademicSession()
    {
        return $this->belongsTo(AcademicSession::class, 'new_academic_session_id');
    }

    public function oldAcademicClass()
    {
        return $this->belongsTo(AcademicClass::class, 'old_academic_class_id');
    }

    public function newAcademicClass()
    {
        return $this->belongsTo(AcademicClass::class, 'new_academic_class_id');
    }

    public function oldCampus()
    {
        return $this->belongsTo(Campus::class, 'old_campus_id');
    }

    public function newCampus()
    {
        return $this->belongsTo(Campus::class, 'new_campus_id');
    }
}
