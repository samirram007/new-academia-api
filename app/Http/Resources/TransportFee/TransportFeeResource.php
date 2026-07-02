<?php

namespace App\Http\Resources\TransportFee;

use App\Http\Resources\AcademicSession\AcademicSessionResource;
use App\Http\Resources\Campus\CampusResource;
use App\Http\Resources\StudentSession\StudentSessionResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\Transport\TransportResource;
use App\Http\Resources\TransportFeeItem\TransportFeeItemCollection;
use App\Http\Resources\TransportUser\TransportUserResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;

class TransportFeeResource extends SuccessResource
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
            'fee_no' => $this->fee_no,
            'fee_date' => $this->fee_date,
            'user_id' => $this->user_id,
            'transport_user_id' => $this->transport_user_id,
            'transport_id' => $this->transport_id,
            "campus_id" =>   $this->campus_id,
            'student_session_id' => $this->student_session_id,
            'academic_session_id' => $this->academic_session_id,
            'total_amount' => $this->total_amount,
            'paid_amount' => $this->paid_amount,
            'balance_amount' => $this->balance_amount,
            'payment_mode' => $this->payment_mode,
            'paid_amount' => $this->paid_amount,
            "transport" => new TransportResource($this->whenLoaded('transport')),
            "academic_session" => new AcademicSessionResource($this->whenLoaded('academic_session')),
            "campus" => new CampusResource($this->whenLoaded('campus')),
            "transport_user" => new TransportUserResource($this->whenLoaded('transport_user')),
            "transport_fee_items" => new TransportFeeItemCollection($this->whenLoaded('transport_fee_items')),
            "student_session" => new StudentSessionResource($this->whenLoaded('student_session')),
            "user" => new UserResource($this->whenLoaded('user')),
        ];
    }
}
