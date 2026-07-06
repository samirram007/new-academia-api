<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminationResult extends Model
{
    use HasFactory;

    protected $fillable=[
        'examination_schedule_id',
        'student_id',
        'marks_obtained',
        'grade',
        'remarks',
    ];


    public function examination_schedule(){
        return $this->belongsTo(ExaminationSchedule::class, 'examination_schedule_id');
    }

    public function student(){
        return $this->belongsTo(User::class);
    }
}
