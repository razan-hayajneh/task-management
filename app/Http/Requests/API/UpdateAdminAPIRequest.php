<?php

namespace App\Http\Requests\API;

use App\Models\Admin;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use InfyOm\Generator\Request\APIRequest;

class UpdateAdminAPIRequest extends APIRequest
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
        $admin = Admin::whereId($this->route("admin"))->first();
        $rules = [
        'full_name'=> 'sometimes',
        'phone_number'=> 'sometimes|numeric|digits:10|unique:users,phone_number,'.$admin->user_id,
        'email'=> 'sometimes|email|unique:users,email,'.$admin->user_id,
        ];
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->ApiResponse('fail', $validator->errors()->first()));
    }

}
