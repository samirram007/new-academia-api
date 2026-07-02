<?php

namespace App\Http\Requests\TransportUser;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransportUserRequest extends FormRequest
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
           'join_date' => ['sometimes','nullable','date'],
            'is_free' => ['sometimes','nullable','boolean'],
            'is_active' => ['sometimes','nullable','boolean'],
            'monthly_charge' => ['sometimes','nullable','numeric'],
            'transport_id' => ['required','exists:transports,id'],
            'journey_type_id' => ['required','exists:journey_types,id'],
            'user_id' => ['required','exists:users,id'],
        ];
    }
}
// Schema::create('transports', function (Blueprint $table) {
//     $table->id();
//     $table->string('name');
//     $table->string('registration_no')->nullable();
//     $table->date('registration_date')->nullable();
//     $table->date('registration_valid_date')->nullable();
//     $table->string('chasis_no')->nullable();
//     $table->string('engine_no')->nullable();
//     $table->string('color')->nullable();
//     $table->integer('capacity')->default(50);
//     $table->string('insurance_no')->nullable();
//     $table->date('insurance_date')->nullable();
//     $table->date('insurance_valid_date')->nullable();
//     $table->integer('insured_value')->default(50);
//     $table->integer('purchase_cost')->default(50);
//     $table->unsignedBigInteger('transport_type_id');
//     $table->timestamps();
// });
