<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            //
            'productId' => 'required|exists:products,id',
            'storeId' => 'required|exists:stores,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'productId.required' => 'Product is a required Field',
            'storeId.required' => 'The store name is required.',
            'quantity.required' => 'The quantity is required.',
            'price.required' => 'The price is required',
        ];
    }

}
