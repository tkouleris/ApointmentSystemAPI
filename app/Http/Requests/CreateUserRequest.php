<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'UsrFirstname' => 'required',
            'UsrLastname' => 'required',
            'UsrEmail' => 'required|email:rfc',
            'UsrRoleID' => 'required|integer|between:1,2',
            'UsrPassword' => 'required|string'
        ];
    }
}
