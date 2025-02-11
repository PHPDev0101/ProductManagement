<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'between:3,255',],
            'description' => ['nullable', 'string', 'max:65535',],
            'price' => ['required', 'numeric', 'between:0.01,' . config('validation.max_price')],
        ];
    }
}
