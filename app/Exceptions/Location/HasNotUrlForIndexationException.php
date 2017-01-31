<?php

namespace App\Exceptions\Location;

use App\Exceptions\SeoException;

class HasNotUrlForIndexationException extends SeoException
{
    
    public function __construct()
    {
        $code = 1103;
        $message = trans('exception.' . $code);
        
        parent::__construct($message, $code);
    }
    
}
