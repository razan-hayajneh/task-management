<?php

namespace App\Http\Requests\API;

use App\Models\Admin;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use InfyOm\Generator\Request\APIRequest;

class CreateAdminAPIRequest extends APIRequest
{
    use ResponseTrait;
    public function __construct(APIRequest $request)
    {
        $request['user_type'] = 'admin';
    }
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
        return Admin::$rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->ApiResponse('fail', $validator->errors()->first()));
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            //
        });
    }
}
