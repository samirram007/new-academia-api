<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookModule extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'book_id',
        'name',
        'description',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
