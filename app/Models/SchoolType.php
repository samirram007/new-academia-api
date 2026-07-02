<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    // protected $table ='school_types';
    // protected $primaryKey = 'id';
    // public $incrementing = true;
      public $timestamps = false;
}
