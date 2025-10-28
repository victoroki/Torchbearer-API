<?php

namespace App\Http\Requests\API;

use App\Models\FormSubmission;
use InfyOm\Generator\Request\APIRequest;

class UpdateFormSubmissionAPIRequest extends APIRequest
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
        $rules = FormSubmission::$rules;
        
        return $rules;
    }
}
