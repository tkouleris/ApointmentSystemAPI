<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IUserRepository;
use App\Models\User;
use JWTAuth;

class UserRepository implements IUserRepository{

    protected $User;

    public function __construct( User $UserModel )
    {
        $this->User = $UserModel;
    }

    public function list( $args )
    {
        return $this->User::all();
    }

    public function findById( $id )
    {
        return $this->User::findOrFail( $id );
    }

    public function findByEmail( $email )
    {
        return $this->User::where('UsrEmail', $email)->first();
    }


    public function create( $data )
    {
        return $this->User::create( $data );
    }

    public function update( $id, $data )
    {
        $this->User::where('UsrID',$id)->update($data);
        return $this->User::findOrFail($id);
    }

    public function findByToken($token)
    {
        return JWTAuth::toUser($token);
    }
}