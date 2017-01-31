<?php

namespace App\Seo;

class URL
{
    /**
     * @var string
     */
    public $protocol;
    
    /**
     * @var string
     */
    public $domain;
    
    /**
     * @var string
     */
    public $path;
    
    
    
    /**
     * @param string $string
     * @return URL
     */
    public function fromString($string)
    {
        $locationArray = url2LocationArray($string);
        
        $this->protocol = $locationArray['protocol'];
        $this->domain = $locationArray['domain'];
        $this->path = $locationArray['path'];
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function get()
    {
        return $this->protocol . $this->domain . $this->path;
    }
    
}
