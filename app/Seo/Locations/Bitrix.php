<?php

namespace App\Seo\Locations;

class Bitrix extends Location
{
    
    /**
     * @see \App\Seo\Locations\Location::forumHomeUrl()
     */
    protected function forumHomeUrl()
    {
        return $this->findLocationDir(
            $this->link->locationDirname()
        ) . '/';
    }
    
    /**
     * @see \App\Seo\Locations\Location::loginPostUrl()
     */
    protected function loginPostUrl($html)
    {
        return $this->findLocationDir(
            $this->link->locationDirname()
        ) . '/?login=yes';
    }
    
    /**
     * @param string $path
     * @return string
     */
    protected function findLocationDir($path)
    {
        return preg_replace('/user.*/', '', $path);
    }
    
    /**
     * @see \App\Seo\Locations\Location::loginPostData()
     */
    protected function loginPostData($html)
    {
        $data = [
            'AUTH_FORM' => 'Y',
            'Login' => 'Login',
            'TYPE' => 'AUTH',
            'USER_LOGIN' => $this->link->username,
            'USER_PASSWORD' => $this->link->password,
            'USER_REMEMBER' => 'Y',
            'backurl' => '/',
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
