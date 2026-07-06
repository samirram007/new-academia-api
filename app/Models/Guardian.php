<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $table = 'guardians';
    protected $fillable = [
        'id',
        'name',
        'email',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_guardian', 'guardian_id', 'student_id');
    }

}
