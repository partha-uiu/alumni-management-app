<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFirstStepReview extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'dist_state' => 'required',
            'country_id' => 'required',
            'user_type_id' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Please enter your first name',
            'last_name.required' => 'Please enter your last name',
            'email.required' => 'Please enter your email',
            'dist_state.required' => 'Please enter your state/district',
            'country_id.required' => 'Please enter your country',
            'user_type_id.required' => 'Please enter your affiliation',
            'password.required' => 'Please enter your password',
        ];
    }
}
