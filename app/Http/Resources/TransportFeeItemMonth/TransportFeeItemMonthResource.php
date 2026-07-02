<?php

namespace App\Http\Resources\TransportFeeItemMonth;

use App\Http\Resources\AcademicSession\AcademicSessionResource;
use App\Http\Resources\Month\MonthResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class TransportFeeItemMonthResource extends SuccessResource
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
            'transport_fee_item_id' => $this->fee_item_id,
            'user_id' => $this->user_id,
            'academic_session_id' => $this->academic_session_id,
            'month_id' => $this->month_id,
            'amount' => $this->amount,
            "month"=>new MonthResource($this->whenLoaded('month')),
            "academic_session"=>new AcademicSessionResource($this->whenLoaded('academic_session')),

        ];
    }
}
