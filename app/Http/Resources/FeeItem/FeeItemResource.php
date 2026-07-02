<?php

namespace App\Http\Resources\FeeItem;

use App\Http\Resources\FeeHead\FeeHeadResource;
use App\Http\Resources\FeeItemMonth\FeeItemMonthCollection;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;


class FeeItemResource extends SuccessResource
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
            'fee_id' => $this->fee_id,
            'fee_head_id' => $this->fee_head_id,
            'quantity' => $this->quantity,
            'amount' => $this->amount,
            'total_amount' => $this->total_amount,
            'months' => $this->months,
            'is_active'=>$this->is_active,
            'is_deleted'=>$this->is_deleted,
            'is_customizable'=>$this->is_customizable,
            'keep_periodic_details'=>$this->keep_periodic_details,
            "fee_head"=>new FeeHeadResource($this->whenLoaded('fee_head')),
             "fee_item_months"=>new FeeItemMonthCollection($this->whenLoaded('fee_item_months')),
        ];
    }
}
