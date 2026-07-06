<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'subject_id',
        'publication_year',
        'page_count',
        'price',
        'published_at',
        'publisher',
        'author',
        'illustrator',
        'translator',
        'cover_image_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function modules()
    {
        return $this->hasMany(BookModule::class);
    }

    public function chapters()
    {
        return $this->hasMany(BookChapter::class);
    }
}
