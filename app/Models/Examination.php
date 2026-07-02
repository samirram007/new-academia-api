<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Examination extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'examination_type_id',
        'examination_start_date',
        'examination_end_date',
        'academic_session_id',
    ];


    public function examination_type()
    {
        return $this->belongsTo(ExaminationType::class);
    }
    public function academic_session()
    {
        return $this->belongsTo(AcademicSession::class);
    }


}
