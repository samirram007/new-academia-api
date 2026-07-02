<?php

namespace App\Http\Resources\Expense;

use App\Http\Resources\AcademicSession\AcademicSessionResource;
use App\Http\Resources\Campus\CampusResource;
use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\ExpenseItem\ExpenseItemCollection;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserResource;

use Illuminate\Http\Request;

class ExpenseResource extends SuccessResource
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
            'user_id' => $this->user_id,
            'academic_session_id' => $this->academic_session_id,
            'total_amount' => $this->total_amount,
            'paid_amount' => $this->paid_amount,
            'balance_amount' => $this->balance_amount,
            'payment_mode' => $this->payment_mode,
            'narration' => $this->narration,
            'document_id' => $this->document_id,
            "academic_session" => new AcademicSessionResource($this->whenLoaded('academic_session')),
            "document" => new DocumentResource($this->whenLoaded('document')),
            "user" => new UserResource($this->whenLoaded('user')),
            "expense_items" => new  ExpenseItemCollection($this->whenLoaded('expense_items')),
        ];
    }
}
