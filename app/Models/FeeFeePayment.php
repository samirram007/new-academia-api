<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FeeFeePayment extends Pivot
{
    protected $table = 'fee_fee_payment';

    protected $fillable = [
        'fee_id', 'fee_payment_id',
        // Add any additional fillable columns here
    ];
    public function fee()
    {
        return $this->belongsTo(Fee::class, 'fee_id');
    }

    public function fee_receipt()
    {
        return $this->belongsTo(FeeReceipt::class, 'fee_receipt_id');
    }
}
