<?php

namespace App\Http\Resources\TransportExpenseItem;

use App\Http\Resources\ExpenseHead\ExpenseHeadResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;


class TransportExpenseItemResource extends SuccessResource
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
            'transport_expense_id' => $this->transport_expense_id,
            'expense_head_id' => $this->expense_head_id,
            'quantity' => $this->quantity,
            'amount' => $this->amount,
            'total_amount' => $this->total_amount,
            'months' => $this->months,
            "expense_head"=>new ExpenseHeadResource($this->whenLoaded('expense_head')),
        ];
    }
}
