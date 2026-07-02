<?php

namespace App\Http\Resources\TransportExpense;

use App\Http\Resources\AcademicSession\AcademicSessionResource;
use App\Http\Resources\Campus\CampusResource;
use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\TransportExpenseItem\TransportExpenseItemCollection;
use App\Http\Resources\User\UserResource;

use Illuminate\Http\Request;


class TransportExpenseResource extends SuccessResource
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
            'expense_no' => $this->expense_no,
            'voucher_no' => $this->voucher_no,
            'expense_date' => $this->expense_date,
            "campus_id" =>  $this->campus_id ,
            'user_id' => $this->user_id,
            'academic_session_id' => $this->academic_session_id,
            'total_amount' => $this->total_amount,
            'paid_amount' => $this->paid_amount,
            'balance_amount' => $this->balance_amount,
            'payment_mode' => $this->payment_mode,
            'paid_amount' => $this->paid_amount,
            'narration' => $this->narration,
            'document_id' => $this->document_id,
            "academic_session" => new AcademicSessionResource($this->whenLoaded('academic_session')),
            "document" => new DocumentResource($this->whenLoaded('document')),
            "campus" => new CampusResource($this->whenLoaded('campus')),
             "user" => new UserResource($this->whenLoaded('user')),
            "transport_expense_items" => new  TransportExpenseItemCollection($this->whenLoaded('transport_expense_items')),
        ];
    }
}

