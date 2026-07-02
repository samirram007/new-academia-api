<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentGuardian extends Pivot
{
    protected $table = 'student_guardian';
    public $incrementing = true;
    protected $fillable = [
        'id','student_id', 'guardian_id',
        // Add any additional fillable columns here
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function guardian()
    {
        return $this->belongsTo(User::class, 'guardian_id');
    }
}
