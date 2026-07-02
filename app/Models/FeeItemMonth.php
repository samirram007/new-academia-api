<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FeeItemMonth extends Model
{
    use HasFactory;
    protected $fillable = [
        'fee_item_id',
        'student_session_id',
        'academic_session_id',
        'fee_id',
        'student_id',
        'month_id',
        'amount',
        'is_deleted'
    ];
    public function fee_item()
    {
        return $this->belongsTo(FeeItem::class);
    }
    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    public function student_session()
    {
        return $this->belongsTo(StudentSession::class);
    }
    public function academic_session()
    {
        return $this->belongsTo(AcademicSession::class);
    }
    public function student()
    {
        return $this->belongsTo(User::class,'student_id');
    }
    public function month()
    {
        return $this->belongsTo(Month::class,'month_id');
    }
}
