<?php

namespace App\Http\Requests\API;

use App\Models\Task;


use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use InfyOm\Generator\Request\APIRequest;
class CreateTaskAPIRequest  extends  APIRequest
{
    use ResponseTrait;
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
        $rules = Task::$rules;

        $rules['project_id'] = $rules['project_id'].',manager_id,'.auth()->user()->id;
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->ApiResponse('fail', $validator->errors()->first()));
    }
}
