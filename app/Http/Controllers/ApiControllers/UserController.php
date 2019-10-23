<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\User;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function addUser(CreateUserRequest $request)
    {
        $token = str_replace("Bearer ", "",$request->header('Authorization'));
        $currentUser = JWTAuth::toUser($token);

        if( !$currentUser->isAdmin() )
        {
            $results['success'] = false;
            $results['message'] = "Not authorized!";
            return response()->json($results,401);
        }

        $request->merge([
            'UsrPassword' => Hash::make($request->input('UsrPassword')),
        ]);
        $User = User::create($request->input());

        $results['success'] = true;
        return response()->json($results,201);
    }
}
