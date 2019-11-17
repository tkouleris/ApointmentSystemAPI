<?php

namespace App\Repositories\Interfaces;

interface IBaseRepository {
    public function list( $args );
    public function findById( $id );
    public function create( $data );
    public function update( $id, $data );
}