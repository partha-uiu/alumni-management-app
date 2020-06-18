<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
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
            'heading.required' => 'Please enter the news heading',
            'description.required' => 'Please enter news description',
        ];
    }

    public function messages()
    {
        return [
            'heading.required' => 'Please enter the news heading',
            'description.required' => 'Please enter news description',
        ];
    }
}
