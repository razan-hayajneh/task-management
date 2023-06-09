<?php

namespace App\Http\Requests\Admin;

use App\Models\TeamMember;


use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTeamMemberRequest  extends  FormRequest
{
    use ResponseTrait;
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
        $teamMember = TeamMember::whereId($this->id)->first();
        $rules = [
        'full_name'=> 'sometimes',
        'phone_number'=> 'sometimes|numeric|digits:10|unique:users,phone_number,'.$teamMember->user_id,
        'email'=> 'sometimes|email|unique:users,email,'.$teamMember->user_id,
        'member_type' => 'sometimes'
        ];
        return $rules;
    }

}
