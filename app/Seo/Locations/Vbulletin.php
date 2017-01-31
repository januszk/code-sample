<?php

namespace App\Seo\Locations;

class Vbulletin extends Location
{
    
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
        return $this->link->locationDirname() . '/login.php?do=login';
    }
    
    /**
     * @see \App\Seo\Locations\Location::loginPostData()
     */
    protected function loginPostData($html)
    {
        $s = inputValue($html, 's');
        $securitytoken = inputValue($html, 'securitytoken');
        
        $data = [
            'cookieuser' => '1',
            'do' => 'login',
            's' => $s,
            'securitytoken' => $securitytoken,
            'vb_login_md5password' => md5($this->link->password),
            'vb_login_md5password_utf' => md5($this->link->password),
            'vb_login_password' => '',
            'vb_login_username' => $this->link->username,
        ];
        
        return $data;
    }
    
    /**
     * @see \App\Seo\Locations\Location::logoutPattern()
     */
    protected function logoutPattern()
    {
        return 'login.php?do=logout';
    }
    
}
