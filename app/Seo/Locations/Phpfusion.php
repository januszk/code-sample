<?php

namespace App\Seo\Locations;

class Phpfusion extends Location
{
    
    /**
     * @see \App\Seo\Locations\Location::forumHomeUrl()
     */
    protected function forumHomeUrl()
    {
        return $this->link->locationDirname() . '/forum/index.php';
    }
    
    /**
     * @see \App\Seo\Locations\Location::loginPostUrl()
     */
    protected function loginPostUrl($html)
    {
        return $this->link->locationDirname() . '/index.php';
    }
    
    /**
     * @see \App\Seo\Locations\Location::loginPostData()
     */
    protected function loginPostData($html)
    {
        $data = [
            'login' => 'Login',
            'remember_me' => 'y',
            'user_name' => $this->link->username,
            'user_pass' => $this->link->password,
        ];
        
        return $data;
    }
    
    /**
     * @see \App\Seo\Locations\Location::logoutPattern()
     */
    protected function logoutPattern()
    {
        return 'logout=yes';
    }
    
}
