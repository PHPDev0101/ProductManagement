<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'between:3,255'],
            'description' => ['sometimes', 'string', 'max:65535'],
            'price' => ['sometimes', 'numeric', 'between:0.01,' . config('validation.max_price')],
        ];
    }

    public function messages(): array
    {
        return [
            'name' => 'The product name must be more that 3 letters long.',
            'price.required' => 'The price is required and must be numeric.',
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422));
    }
}
