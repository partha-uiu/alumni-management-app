<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'payment_info' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'title.required' => 'Please enter the heading',
            'description.required' => 'Please enter the description',
            'payment_info.required' => 'Please enter the payment information',
        ];
    }

}
