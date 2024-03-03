<?php

namespace Core\Infrastructure\Http\Request;

class AddProductToSaleRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'productId' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'The sale ID is required.',
            'id.integer' => 'The sale ID must be an integer.',
            'id.exists' => 'The specified sale does not exist.',
            'productId.required' => 'The product ID is required.',
            'productId.integer' => 'The product ID must be an integer.',
            'productId.exists' => 'The specified product does not exist.',
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity must be at least 1.',
        ];
    }
}
