<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoutine extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_of_week',
        'academic_session_id',
        'academic_class_id',
        'subject_id',
        'teacher_id',
        'room_id',
        'start_time',
        'end_time',
    ];

    public function academic_session()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    public function academic_class()
    {
        return $this->belongsTo(AcademicClass::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
