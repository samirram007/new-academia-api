<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'description',
        'subject_type',
        'subject_group_id',
        'academic_standard_id',
        'logo_image_id'
    ];
    public function logo_image()
    {
        return $this->belongsTo(Document::class, 'logo_image_id');
    }
    public function subject_group()
    {
        return $this->belongsTo(SubjectGroup::class);
    }
    public function academic_standard()
    {
        return $this->belongsTo(AcademicStandard::class);
    }
}

