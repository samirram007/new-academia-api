<?php

namespace App\Http\Resources\FeeTemplateItem;

use Illuminate\Http\Request;
use App\Http\Resources\FeeHead\FeeHeadResource;

use App\Http\Resources\FeeTemplate\FeeTemplateResource;
use App\Http\Resources\SuccessResource;

class FeeTemplateItemResource extends SuccessResource
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
            'is_active'=>$this->is_active,
            'sort_index'=>$this->sort_index,
            'amount'=>$this->amount,
            'is_customizable'=>$this->is_customizable,
            'keep_periodic_details'=>$this->keep_periodic_details,
            'fee_template_id'=>$this->fee_template_id,
            'fee_head_id'=>$this->fee_head_id,
            'fee_head'=>new FeeHeadResource($this->whenLoaded('fee_head'))  ,

        ];
    }
}
