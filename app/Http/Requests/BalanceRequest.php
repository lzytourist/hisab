<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BalanceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'details' => '',
            'amount' => '',
            'method_id' => 'required|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'method_id.required' => 'Method is required.',
            'method_id.min' => 'Please select an method.'
        ];
    }
}
