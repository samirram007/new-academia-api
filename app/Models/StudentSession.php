<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentSession extends Pivot
{
    protected $table = 'student_sessions';
    public $incrementing = true;
    protected $fillable = [
         'student_id', 'academic_session_id','campus_id', 'academic_class_id','academic_standard_id','section_id',
        'roll_no','status','is_promoted','previous_student_session_id','next_student_session_id',
        'is_idcard_printable','idcard_print_count'
        // Add any additional fillable columns here
    ];
    function campus(){
        return $this->belongsTo(Campus::class);
    }
    function student(){
        return $this->belongsTo(User::class,'student_id');
    }

    function academic_session(){
        return $this->belongsTo(AcademicSession::class);
    }

    function academic_class(){
        return $this->belongsTo(AcademicClass::class);
    }

    function academic_standard(){
        return $this->belongsTo(AcademicStandard::class);
    }
    function section(){
        return $this->belongsTo(Section::class);
    }
    function next_student_session(){
        return $this->belongsTo(StudentSession::class);
    }
    function previous_student_session(){
        return $this->belongsTo(StudentSession::class);
    }
    function fee_item_months(){
        return $this->hasMany(FeeItemMonth::class,'student_session_id');
    }

}
