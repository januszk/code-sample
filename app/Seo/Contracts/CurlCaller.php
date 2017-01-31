<?php

namespace App\Seo\Contracts;

use App\Seo\Curl;

interface CurlCaller
{
    
    /**
     * Curl success action
     * 
     * @param Curl $curl
     * @return void
     */
    public function success(Curl $curl);
    
    /**
     * Curl error action
     * 
     * @param Curl $curl
     * @return void
     */
    public function error(Curl $curl);
    
    /**
     * Get cookie file full path + name
     * 
     * @return string
     */
    public function cookieFile();
    
    /**
     * Get current url
     * 
     * @return string
     */
    public function getCurrentUrl();
    
    /**
     * Get current referer url
     * 
     * @return string
     */
    public function getCurrentReferer();
    
}
