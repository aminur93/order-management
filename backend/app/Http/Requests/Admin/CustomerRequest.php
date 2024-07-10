<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (Request::routeIs('customer.store')) {
            return [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:customers',
                'phone' => 'required|string|max:11|unique:customers',
                'address' => 'required|string|max:255',
            ];
        }

        if (Request::routeIs('customer.update')) {
            return [
                'first_name' => 'sometimes|string|max:255',
                'last_name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|unique:customers',
                'phone' => 'sometimes|string|max:11|unique:customers',
                'address' => 'sometimes|string|max:255',
            ];
        }

        return [];
    }
}
