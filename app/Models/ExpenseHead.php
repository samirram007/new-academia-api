<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseHead extends Model
{
    use  HasFactory;
    protected $fillable = [
        'name',
        'expense_group_id',

    ];
    public function expense_group() {
        return $this->belongsTo(ExpenseGroup::class);
    }
}
