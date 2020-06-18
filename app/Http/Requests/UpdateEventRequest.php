<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'start_date' => 'required',
            'start_time' => 'required',
            'end_date' => 'required',
            'end_time' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Please enter event title',
            'description.required' => 'Please enter event description',
            'start_date.required' => 'Please enter  start date ',
            'end_date.required' => 'Please enter  end date ',
            'start_time.required' => 'Please enter  start time ',
            'end_time.required' => 'Please enter  end time ',
        ];
    }

}
