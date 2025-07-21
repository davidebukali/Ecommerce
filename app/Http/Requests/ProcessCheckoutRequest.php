<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessCheckoutRequest extends FormRequest
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
            'cart_id'          => ['required', 'exists:carts,id'],
            'order_number'     => ['required', 'string', 'unique:orders,order_number'],
            'subtotal'         => ['required', 'numeric', 'min:0'],
            'delivery_fee'     => ['required', 'numeric', 'min:0'],
            'total'            => ['required', 'numeric', 'min:0'],
            'payment_status'   => ['required', 'string', 'in:paid,unpaid,pending'], // Add more statuses if needed
            'transaction_id'   => ['nullable', 'string', 'max:255', 'unique:orders,transaction_id'], // Nullable for COD
            'delivery_address' => ['required', 'string', 'max:500'],
            'payment_method'   => ['required', 'string', 'in:cod,mobile_money,visa'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'cart_id.required' => 'The cart ID is missing.',
            'cart_id.exists'   => 'The specified cart does not exist.',
            'order_number.unique' => 'The order number has already been taken. Please try again.',
            'delivery_address.required' => 'Please provide a delivery address.',
            'payment_method.required' => 'Please select a payment method.',
        ];
    }
}
