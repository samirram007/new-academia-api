<?php

namespace App\Http\Resources\ExpenseHead;

use App\Http\Resources\ExpenseGroup\ExpenseGroupResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;


class ExpenseHeadResource extends SuccessResource
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
            'name' => $this->name,
            'expense_group_id' => $this->expense_group_id,
            "expense_group"=>new ExpenseGroupResource($this->whenLoaded('expense_group')),

        ] ;
    }
}
