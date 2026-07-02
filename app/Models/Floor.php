<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Floor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'building_id',
        'capacity'
    ];
    public function building() {
        return $this->belongsTo(Building::class);
     }

}
