<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeTemplateItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_active',
        'sort_index',
        'fee_template_id',
        'fee_head_id',
        'amount',
        'is_customizable',
        'keep_periodic_details',
    ];
    public function fee_template() {
        return $this->belongsTo(FeeTemplate::class);
    }
    public function fee_head() {
        return $this->belongsTo(FeeHead::class);
    }

}
