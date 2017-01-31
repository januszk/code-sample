<?php

namespace App\Exceptions\Location;

use App\Exceptions\SeoException;

class HasNotLinkException extends SeoException
{
    
    public function __construct()
    {
        $code = 1101;
        $message = trans('exception.' . $code);
        
        parent::__construct($message, $code);
    }
    
}
