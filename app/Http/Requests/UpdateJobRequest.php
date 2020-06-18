<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
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
            'job_title' => 'required',
            'company_name' => 'required',
            'job_type' => 'required',
            'location' => 'required',
            'description' => 'required',
            'post_date' => 'required',
            'end_date' => 'required',
            'educational_requirements' => 'required',
            'job_requirements' => 'required',
            'salary_range' => 'required',
            'apply_instruction' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'job_title.required' => 'Please enter the job title',
            'company_name.required' => 'Please enter the company name',
            'job_type.required' => 'Please enter job nature',
            'description.required' => 'Please enter job description',
            'location.required' => 'Please enter job location',
            'post_date.required' => 'Please enter post date',
            'end_date.required' => 'Please enter end date',
            'educational_requirements.required' => 'Please enter educational requirements',
            'job_requirements.required' => 'Please enter job requirements',
            'salary_range.required' => 'Please enter salary range',
            'apply_instruction.required' => 'Please enter apply instruction',
        ];
    }
}
