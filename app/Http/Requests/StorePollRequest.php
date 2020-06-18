<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePollRequest extends FormRequest
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
            'max_checkable' => 'required',
            'title' => 'required',
            'option_name.*' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'max_checkable.required' => 'Please enter the maximum checkable option',
            'poll_question.required' => 'Please enter the poll question',
           
        ];
    }
}
