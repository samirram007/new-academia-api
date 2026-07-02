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
       'old_academic_session_id',
       'old_academic_class_id',
       'new_academic_session_id',
       'new_academic_class_id',
        'is_active',
        'is_deleted'
    ];
}
