<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'expense_no',
        'voucher_no',
        'expense_date',
        'user_id',
        'academic_session_id',
        'total_amount',
        'paid_amount',
        'balance_amount',
        'payment_mode',
        'narration',

    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function academic_session() {
        return $this->belongsTo(AcademicSession::class);
    }




    public function expense_items(){
        return $this->hasMany(ExpenseItem::class);
    }

}
