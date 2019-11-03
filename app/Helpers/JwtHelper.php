<?php

namespace App\Helper;

use App\Helper\Interfaces\IJwtHelper;

class JwtHelper implements IJwtHelper{

    public function get_token_from_request( $request )
    {
        return str_replace("Bearer ", "",$request->header('Authorization'));
    }

}