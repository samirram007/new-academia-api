<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminationSchedule extends Model
{
    use HasFactory;
    protected $fillable=[
        'examination_standard_id',
        'examination_date',
        'examination_time',
        'subject_id',
        'teacher_id'
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

}
