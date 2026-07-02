<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeHead extends Model
{
    use  HasFactory;
    protected $fillable = [
        'name',
        'income_group_id',
    ];
    public function income_group() {
        return $this->belongsTo(IncomeGroup::class);
    }
}
