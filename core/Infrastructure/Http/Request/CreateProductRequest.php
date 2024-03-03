<?php

namespace Core\Infrastructure\Http\Request;

class CreateProductRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'price.required' => 'O preço do produto é obrigatório.',
            'price.numeric' => 'O preço do produto deve ser um número.',
            'price.min' => 'O preço do produto não pode ser negativo.',
            'description.required' => 'A descrição do produto é obrigatória.',
        ];
    }
}
