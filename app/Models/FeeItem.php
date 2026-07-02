<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'fee_id',
        'fee_head_id',
        'quantity',
        'months',
        'amount',
        'is_active',
        'keep_periodic_details',
        'is_customizable',
        'is_deleted',
        'total_amount',
    ];
    public function fee()
    {
        return $this->belongsTo(Fee::class, 'fee_id');
    }

    public function fee_head()
    {
        return $this->belongsTo(FeeHead::class, 'fee_head_id');
    }
    public function fee_item_months(){
        return $this->hasMany(FeeItemMonth::class);
    }
}
