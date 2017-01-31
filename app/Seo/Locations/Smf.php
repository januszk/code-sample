<?php

namespace App\Seo\Locations;

class Smf extends Location
{
    
    /**
     * @see \App\Seo\Locations\Location::getLogin()
     */
    public function getLogin($useCookie = true)
    {
        $url = $this->link->locationDirname() . '/index.php?action=login';
        
        $curl = $this->initNewStep(__FUNCTION__, $url, $useCookie);
        
        $curl->exec();
    }
    
    /**
     * @see \App\Seo\Locations\Location::forumHomeUrl()
     */
    protected function forumHomeUrl()
    {
        return $this->link->locationDirname() . '/index.php';
    }
    
    /**
     * @see \App\Seo\Locations\Location::loginPostUrl()
     */
    protected function loginPostUrl($html)
    {
        return $this->link->locationDirname() . '/index.php?action=login2';
    }
    
    /**
     * @see \App\Seo\Locations\Location::loginPostData()
     */
    protected function loginPostData($html)
    {
        $data = [
            'cookielength' => '60',
            'cookieneverexp' => 'on',
            'hash_passwrd' => '',
            'passwrd' => $this->link->password,
            'user' => $this->link->username,
        ];
        
        return $data;
    }
    
    /**
     * @see \App\Seo\Locations\Location::logoutPattern()
     */
    protected function logoutPattern()
    {
        return 'action=logout';
    }
    
}
