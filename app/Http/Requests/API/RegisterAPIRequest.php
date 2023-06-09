<?php

namespace App\Http\Requests\API;

use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use InfyOm\Generator\Request\APIRequest;

class RegisterAPIRequest extends  APIRequest
{
    use ResponseTrait;
    public function __construct(Request $request)
    {
        $request['user_type'] = 'team_member';
        $request['member_type'] = 'team_member';
    }
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'full_name' => 'required',
            'phone_number' => 'required|numeric|digits:10|unique:users,phone_number',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirmed_password' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function filters()
    {
        return [
            'email' => 'trim|lowercase',
            'name'  => 'trim|capitalize|escape'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            //
        });
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->ApiResponse('fail', $validator->errors()->first()));
    }
}
