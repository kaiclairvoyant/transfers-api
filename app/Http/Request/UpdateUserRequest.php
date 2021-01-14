<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
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
        return [
            'credit' => 'integer|nullable',
            'document' => '',
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
            'password' => 'required|string',
            'user_type_id' => 'required|integer',
        ];
    }
}