<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'description' => ['required'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/']
        ];
    }

    public function messages()
    {
        return [
            'price.required' => 'The price field is required',
            'price.numeric' => 'The price must be a number.',
            'price.regex' => 'The price must up two decimal only'
        ];   
    }
}
