<?php

namespace App\Http\Requests\API;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use InfyOm\Generator\Request\APIRequest;

class UpdateUserAPIRequest extends APIRequest
{
    use ResponseTrait;

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
        $user = User::whereId(auth()->user()->id)->first();
        $rules = [
        'full_name'=> 'sometimes',
        'phone_number'=> 'sometimes|numeric|digits:10|unique:users,phone_number,'.$user->id,
        'email'=> 'sometimes|email|unique:users,email,'.$user->id,
        ];
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->ApiResponse('fail', $validator->errors()->first()));
    }

}
