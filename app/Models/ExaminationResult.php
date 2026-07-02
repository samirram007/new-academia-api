<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminationResult extends Model
{
    use HasFactory;

    protected $fillable=[
        'examination_scheduled_id',
        'marks',
        'student_id'
    ];


    public function examination_scheduled(){
        return $this->belongsTo(ExaminationSchedule::class);
    }

    public function student(){
        return $this->belongsTo(User::class);
    }
}
