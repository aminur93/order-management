<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProductRequest extends FormRequest
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
        if (Request::routeIs('product.store')) {
            return [
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'price' => 'required|min:0',
            ];
        }

        if (Request::routeIs('product.update')) {
            return [
                'name' => 'sometimes|string|max:255',
                'description' => 'sometimes|string|max:1000',
                'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
                'price' => 'sometimes|min:0',
            ];
        }

        return [];
    }
}
