<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class CreateUserRequest extends FormRequest
{

    protected $UserRepository;

    public function __construct( UserRepository $User)
    {
        $this->UserRepository = $User;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $token = str_replace("Bearer ", "",$this->header('Authorization'));

        $currentUser = $this->UserRepository->findByToken( $token );
        if( !$currentUser->isAdmin() ) return false;
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

    protected function failedAuthorization()
    {
        $results['success'] = false;
        $results['message'] = 'Not authorized!';
        return new JsonResponse( $results, 401);
    }

    /**
    * Handle a failed validation attempt.
    *
    * @param  \Illuminate\Contracts\Validation\Validator  $validator
    * @return void
    *
    * @throws \Illuminate\Validation\ValidationException
    */
    protected function failedValidation(Validator $validator)
    {
        $results['success'] = false;
        $results['message'] = 'Bad Request!';
        $response = new JsonResponse( $results, 400);
        throw new ValidationException($validator, $response);
    }
}
