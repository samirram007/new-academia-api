<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Document;
use App\Models\EducationBoard;
use App\Models\SchoolType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class School extends Model
{
    use  HasFactory;
    protected $fillable = [
        'name',
        'code',
        'education_board_id',
        'address_id',
        'contact_no',
        'email',
        'website',
        'establishment_date',
        'logo_image_id',
        'school_type_id',

    ];
    public function education_board()
    {
        return $this->belongsTo(EducationBoard::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function school_type()
    {
        return $this->belongsTo(SchoolType::class);
    }
    public function logo_image()
    {
        return $this->belongsTo(Document::class);
    }

}
