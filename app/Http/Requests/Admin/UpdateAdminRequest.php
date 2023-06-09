<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{

     /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $admin = Admin::whereId($this->id)->first();
        $rules = [
        'full_name'=> 'sometimes',
        'phone_number'=> 'sometimes|numeric|digits:10|unique:users,phone_number,'.$admin->user_id,
        'email'=> 'sometimes|email|unique:users,email,'.$admin->user_id,
        ];
        return $rules;
    }


}
