<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'UsrEmail' => 'required',
            'UsrPassword' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $results['success'] = false;
        $results['message'] = 'Bad Request!';
        $response = new JsonResponse( $results, 400);
        throw new ValidationException($validator, $response);
    }
}
