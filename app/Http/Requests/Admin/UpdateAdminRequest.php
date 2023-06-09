<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{

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


}
