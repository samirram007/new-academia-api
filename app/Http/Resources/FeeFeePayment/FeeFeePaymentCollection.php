<?php

namespace App\Http\Resources\FeeFeePayment;

use App\Http\Resources\SuccessCollection;
use Illuminate\Http\Request;

class FeeFeePaymentCollection extends SuccessCollection
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
