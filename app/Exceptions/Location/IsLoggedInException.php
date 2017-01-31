<?php

namespace App\Exceptions\Location;

use App\Exceptions\SeoException;

class IsLoggedInException extends SeoException
{

    public function __construct()
    {
        $code = 9102;
        $message = trans('exception.' . $code);
        
        parent::__construct($message, $code);
    }

}
