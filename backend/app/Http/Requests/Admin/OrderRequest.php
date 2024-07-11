<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class OrderRequest extends FormRequest
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
        if (Request::routeIs('order.store'))
        {
            return [
                'customer_id' => 'required|exists:customers,id',
                'total_amount' => 'required|numeric',
//                'product_id' => 'required|exists:products,id',
//                'quantity' => 'required|numeric',
//                'price' => 'required|numeric',
            ];
        }

        if (Request::routeIs('order.update'))
        {
            return [
                'customer_id' => 'sometimes|exists:customers,id',
                'total_amount' => 'sometimes|numeric',
//                'product_id' => 'sometimes|exists:products,id',
//                'quantity' => 'sometimes|numeric',
//                'price' => 'sometimes|numeric',
            ];
        }

        return [];
    }
}
