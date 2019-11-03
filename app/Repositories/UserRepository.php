<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IUserRepository;

use App\Models\User;

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
        // TODO
    }

    public function update( $data )
    {
        // TODO
    }

    public function delete( $id )
    {
        // TODO
    }
}