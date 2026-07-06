<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $fillable = [
        'id',
        'name',
        'username',
        'user_type',
        'code',
        'emergency_contact_name',
        'emergency_contact_no',
        'birth_mark',
        'medical_conditions',
        'gender',
        'contact_no',
        'email',
        'admission_date',
    ];
}
