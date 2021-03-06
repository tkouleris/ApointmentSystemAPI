<?php

namespace App\Repositories\Interfaces;

interface IUserRepository extends IBaseRepository{

    public function findByEmail( $email );

    public function findByToken( $token );
}