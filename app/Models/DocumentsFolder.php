<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentsFolder extends Model
{
    use HasFactory;
    protected $fillable = [
        'document_id',
        'folder_id',
    ];
    public function document(){
        return $this->belongsTo(Document::class);
    }
    public function folder(){
        return $this->belongsTo(Document::class,'folder_id');
    }
}
