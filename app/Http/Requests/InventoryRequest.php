<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
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
            'VIN' => 'required|integer',
            'model_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|integer',
            'color' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,bmp,png|max:2048',
            'category' => 'required|string|max:255',
            'stock' => 'required|integer',
            'sales' => 'required|integer',
            'dealer' => 'required|string|max:255',
            'user_id' => 'required|integer',
            'dealer_id' => 'required|integer',
        ];
    }
}
