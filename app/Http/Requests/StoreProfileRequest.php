<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
            'state_dist' => 'required',
            'country_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'state_dist.required' => 'Please enter your state',
            'country_id.required' => 'Please enter your country',
        ];
    }
}
