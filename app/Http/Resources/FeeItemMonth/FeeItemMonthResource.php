<?php

namespace App\Http\Resources\FeeItemMonth;

use App\Http\Resources\Month\MonthResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;


class FeeItemMonthResource extends SuccessResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'fee_item_id' => $this->fee_item_id,
            'student_session_id' => $this->student_session_id,
            'month_id' => $this->month_id,
            'amount' => $this->amount,
            'is_deleted'=>$this->is_deleted,
            "month"=>new MonthResource($this->whenLoaded('month')),

        ];
    }
}
