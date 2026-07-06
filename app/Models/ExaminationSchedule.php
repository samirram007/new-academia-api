<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminationSchedule extends Model
{
    use HasFactory;
    protected $fillable=[
        'examination_standard_id',
        'subject_id',
        'teacher_id',
        'exam_date',
        'start_time',
        'end_time',
        'room_id',
    ];


    public function examination_standard()
    {
        return $this->belongsTo(ExaminationStandard::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function teacher()
    {
        return $this->belongsTo(User::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function results()
    {
        return $this->hasMany(ExaminationResult::class, 'examination_schedule_id');
    }

}
