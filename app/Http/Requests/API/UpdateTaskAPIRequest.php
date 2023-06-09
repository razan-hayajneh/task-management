<?php

namespace App\Http\Requests\API;

use App\Models\Task;


use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use InfyOm\Generator\Request\APIRequest;class UpdateTaskAPIRequest  extends  APIRequest
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
        $rules = [
            'name' => 'sometimes',
            'task_status' => 'sometimes|in:created,progress,finished',
            'category_id' => 'sometimes|exists:task_categories,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date'
        ];

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->ApiResponse('fail', $validator->errors()->first()));
    }
}
