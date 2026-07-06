<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminationStandard extends Model
{
    use HasFactory;

    protected $fillable=[
        'academic_standard_id',
        'examination_id',
        'subject_id',
        'passing_marks',
        'total_marks',
    ];

    public function academic_standard(){
       return $this->belongsTo(AcademicStandard::class);
    }

    public function examination(){
       return $this->belongsTo(Examination::class);
    }

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function schedules(){
        return $this->hasMany(ExaminationSchedule::class, 'examination_standard_id');
    }
}
