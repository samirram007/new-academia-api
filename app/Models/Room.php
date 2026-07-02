<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'floor_id',
        'is_available',
        'capacity',
        'room_type'
    ];
    public function floor() {
        return $this->belongsTo(Floor::class);
     }
}
