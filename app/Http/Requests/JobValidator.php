<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return $this->user()->isEmployer() && !empty($this->user()->employerCredit->credit);
        return $this->user()->isEmployer();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'required',
            'title' => 'required|max:255',
            'type' => 'required',
            'budget' => 'required', 
            'description' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category_id.required' => 'Job Category is required.',
            'title.required' => 'Job Title is required.',
            'title.max' => 'Job Title must not exceed 255 characters.',
            'type.required' => 'Job Type is required.',
            'budget.required' => 'Budget is required.',
            'description.required' => 'Description is required.',
        ];
    }
}
