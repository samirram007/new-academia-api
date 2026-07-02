<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicClass extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'campus_id',
        'academic_standard_id',
        'capacity'
    ];
    public function academic_standard()
    {
        return $this->belongsTo(AcademicStandard::class);
    }
    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

}
