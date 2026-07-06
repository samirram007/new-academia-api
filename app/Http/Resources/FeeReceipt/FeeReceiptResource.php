<?php

namespace App\Http\Resources\FeeReceipt;

use App\Http\Resources\Fee\FeeCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeeReceiptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'receipt_no' => $this->receipt_no,
            'receipt_date' => $this->receipt_date,
            'amount' => (float) $this->amount,
            'payment_mode' => $this->payment_mode,
            'receipt_note' => $this->receipt_note,
            'is_system_receipt' => $this->is_system_receipt,
            'system_receipt_date' => $this->system_receipt_date,
            'paid_by_user_id' => $this->paid_by_user_id,
            'paid_by' => $this->whenLoaded('paidBy', fn() => [
                'id' => $this->paidBy->id,
                'name' => $this->paidBy->name,
            ]),
            'fees' => FeeCollection::make($this->whenLoaded('fees')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
