<?php

namespace App\Http\Requests\Api;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class LoginRequest extends FormRequest
{
    use ResponseTrait;
    public function __construct(Request $request)
    {
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'       => 'required',
            'password'       => 'required',
        ];
    }


    public function filters()
    {
        return [
            'email' => 'trim|lowercase'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        //$errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException($this->ApiResponse('fail', $validator->errors()->first()));
    }
}
