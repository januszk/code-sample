<?php

namespace App\Seo\Locations;

class Fluxbbandpunbb extends Location
{
    
    /**
     * @see \App\Seo\Locations\Location::getLogin()
     */
    public function getLogin($useCookie = true)
    {
        $url = $this->link->locationDirname() . '/login.php';
        
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
        return $this->link->locationDirname() . '/login.php?action=in';
    }
    
    /**
     * @see \App\Seo\Locations\Location::loginPostData()
     */
    protected function loginPostData($html)
    {
        $redirectUrl = inputValue($html, 'redirect_url');
        
        $data = [
            'form_sent' => '1',
            'login' => 'Login',
            'redirect_url' => $redirectUrl,
            'req_password' => $this->link->password,
            'req_username' => $this->link->username,
            'save_pass' => 1,
        ];
        
        return $data;
    }
    
    /**
     * @see \App\Seo\Locations\Location::logoutPattern()
     */
    protected function logoutPattern()
    {
        return 'action=out';
    }
    
}
