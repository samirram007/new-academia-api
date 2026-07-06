<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FeeReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'paid_by_user_id',
        'receipt_date',
        'amount',
        'payment_mode',
        'receipt_no',
        'receipt_note',
        'is_system_receipt',
        'system_receipt_date',
    ];

    protected function casts(): array
    {
        return [
            'receipt_date' => 'date',
            'system_receipt_date' => 'datetime',
            'is_system_receipt' => 'boolean',
            'amount' => 'decimal:2',
        ];
    }

    public function fees(): BelongsToMany
    {
        return $this->belongsToMany(Fee::class, 'fee_fee_receipts')
            ->withTimestamps();
    }

    public function paidBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by_user_id');
    }
}
