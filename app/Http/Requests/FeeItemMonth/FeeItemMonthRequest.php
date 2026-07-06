<?php

namespace App\Http\Requests\FeeItemMonth;

use Illuminate\Foundation\Http\FormRequest;

class FeeItemMonthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
