<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;

class UserController extends Controller
{

    protected $UserRepository;

    public function __construct( UserRepository $User)
    {
        $this->UserRepository = $User;
    }

    public function addUser(CreateUserRequest $request)
    {
        $token = str_replace("Bearer ", "",$request->header('Authorization'));

        $currentUser = $this->UserRepository->findByToken( $token );
        if( !$currentUser->isAdmin() )
        {
            $results['success'] = false;
            $results['message'] = "Not authorized!";
            return response()->json($results,401);
        }

        $request->merge([
            'UsrPassword' => Hash::make($request->input('UsrPassword')),
        ]);
        $this->UserRepository->create( $request->input() );


        $results['success'] = true;
        return response()->json($results,201);
    }
}
