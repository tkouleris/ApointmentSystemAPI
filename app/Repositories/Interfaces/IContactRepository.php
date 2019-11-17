<?php

namespace App\Repositories\Interfaces;

interface IContactRepository extends IBaseRepository{
    public function delete( $id );

}