<?php

namespace App\Seo\Locations;

class Mybb extends Location
{
    
    /**
     * @see \App\Seo\Locations\Location::getLogin()
     */
    public function getLogin($useCookie = true)
    {
        $url = $this->link->locationDirname() . '/member.php?action=login';
        
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
        return $this->link->locationDirname() . '/member.php';
    }
    
    /**
     * @see \App\Seo\Locations\Location::loginPostData()
     */
    protected function loginPostData($html)
    {
        $url = inputValue($html, 'url');
        
        $data = [
            'username' => $this->link->username,
            'password' => $this->link->password,
            'action' => 'do_login',
            'remember' => 'yes',
            'url' => $url,
            'submit' => 'Login',
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
