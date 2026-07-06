<?php

namespace App\Http\Resources\FeeFeePayment;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class FeeFeePaymentResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fee_id' => $this->fee_id,
            'fee_payment_id' => $this->fee_payment_id,
        ];
    }
}
