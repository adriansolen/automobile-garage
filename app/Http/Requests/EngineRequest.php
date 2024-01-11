<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EngineRequest extends FormRequest
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
            'engine_type' => 'required|string|max:255',
            'displacement' => 'required|integer',
            'maximum_output' => 'required|string|max:255',
            'maximum_torque' => 'required|string|max:255',
            'fuel_type' => 'required|string|max:255',
            'fuel_capacity' => 'required|string|max:255',
            'user_id' => 'required|integer',
            'VIN' => 'required|integer',
        ];
    }
}
