<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fee extends Model
{
    use HasFactory;
    protected $fillable = [
        'fee_no',
        'fee_date',
        'fee_template_id',
        'student_id',
        'academic_session_id',
        'student_session_id',
        'academic_class_id',
        'campus_id',
        'total_amount',
        'paid_amount',
        'balance_amount',
        'payment_mode',
         'is_deleted',
         'note'

    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function fee_template() {
        return $this->belongsTo(FeeTemplate::class);
    }
    public function student() {
        return $this->belongsTo(User::class,'student_id');
    }
    public function academic_session() {
        return $this->belongsTo(AcademicSession::class);
    }
    public function campus() {
        return $this->belongsTo(Campus::class);
    }
    public function academic_class() {
        return $this->belongsTo(AcademicClass::class);
    }
    public function student_session() {

        return $this->belongsTo(StudentSession::class,'student_session_id') ;
    }
    public function fee_items(){
        return $this->hasMany(FeeItem::class);
    }
    public function fee_item_months(){
        return $this->hasMany(FeeItemMonth::class);
    }

    public function fee_receipts()
    {
        return $this->belongsToMany(FeeReceipt::class, 'fee_fee_receipts')
            ->withTimestamps();
    }
}
