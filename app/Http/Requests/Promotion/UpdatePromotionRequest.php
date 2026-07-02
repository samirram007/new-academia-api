<?php

namespace App\Http\Requests\Promotion;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'promotion_no'=> ['required','string','max:255'],
            'promotion_date'=> ['required', 'date'],
            'promotion_template_id'=> ['required', 'exists:promotion_templates,id'],
            'student_id' =>  ['required','numeric', 'exists:users,id'],
            'academic_session_id'=> ['required', 'exists:academic_sessions,id'],
            'campus_id'=> ['required', 'exists:campuses,id'],
            'academic_class_id'=> ['required', 'exists:academic_classes,id'],
            'total_amount'=> ['required', 'numeric'],
            'paid_amount'=> ['sometimes','required', 'numeric'],
            'balance_amount'=> ['sometimes','required', 'numeric'],
            'payment_mode'=> ['sometimes','required','string','max:255'],
            'promotion_items'=> ['sometimes','required', 'array'],
            'promotion_items.*.promotion_head_id'=> ['required', 'exists:promotion_heads,id'],
            'promotion_items.*.quantity'=> ['required', 'numeric'],
            'promotion_items.*.is_customizable'=> ['required', 'numeric'],
            'promotion_items.*.keep_periodic_details'=> ['required', 'numeric'],
            'promotion_items.*.is_active'=> ['required', 'numeric'],
            'promotion_items.*.months'=> ['sometimes','nullable', 'array'],
            'promotion_items.*.amount'=> ['required', 'numeric'],
            'promotion_items.*.total_amount'=> ['required', 'numeric'],

        ];
    }
}
