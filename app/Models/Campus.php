<?php

namespace App\Models;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Campus extends Model
{
    use  HasFactory;
    protected $fillable = [

        'name',
        'code',
        'school_id',
        'education_board_id',
        'address_id',
        'contact_no',
        'email',
        'opening_time',
        'closing_time',
        'establishment_date',
        'logo_image_id',
    ];
    public function education_board()
    {
        return $this->belongsTo(EducationBoard::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function logo_image()
    {
        return $this->belongsTo(Document::class);
    }

}
