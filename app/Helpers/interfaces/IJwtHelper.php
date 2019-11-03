<?php

namespace App\Helper\Interfaces;

interface IJwtHelper {

    public function get_token_from_request( $request );

    public function invalidate_token( $token );
}