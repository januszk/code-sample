<?php

namespace App\Exceptions\Location;

use App\Exceptions\SeoException;

class IsNotLoggedInException extends SeoException
{

    public function __construct()
    {
        $code = 1102;
        $message = trans('exception.' . $code);
        
        parent::__construct($message, $code);
    }

}
