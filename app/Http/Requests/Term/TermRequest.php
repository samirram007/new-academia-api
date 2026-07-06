<?php

namespace App\Http\Requests\Term;

use Illuminate\Foundation\Http\FormRequest;

class TermRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
