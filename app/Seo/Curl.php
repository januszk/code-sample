<?php

namespace App\Seo;

use Curl\Curl as BaseCurl;
use App\Seo\Contracts\CurlCaller;

class Curl extends BaseCurl
{
    
    /**
     * @var CurlCaller
     */
    protected $caller;
    
    /**
     * @var array
     */
    protected $postData = [];
    
    
    
    /**
     * @param CurlCaller $caller
     * @param bool $useCookie
     * @param int $timeout
     * @return void
     */
    public function __construct(CurlCaller $caller, $useCookie = true, $timeout = 30)
    {
        parent::__construct(null);
        
        $this->caller = $caller;
        
        $this->setTimeout($timeout);
        
        $this->setHeader('User-Agent', 'Mozilla/5.0 (Windows NT 6.0; rv:43.0) Gecko/20100101 Firefox/43.0');
        $this->setHeader('Accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8');
        $this->setHeader('Accept-Language', 'pl,en-US;q=0.7,en;q=0.3');
        $this->setHeader('Connection', 'keep-alive');
        $this->setHeader('Pragma', 'no-cache');
        $this->setHeader('Cache-Control', 'no-cache');
        
        $this->setOpt(CURLOPT_HEADER, true);
        $this->setOpt(CURLOPT_FOLLOWLOCATION, true);
        $this->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        
        if ($useCookie) {
            $cookieFile = $this->caller->cookieFile();
            $this->setCookieJar($cookieFile);
            $this->setCookieFile($cookieFile);
        }
        
        $this->success(function () {
            $this->caller->success($this);
        });
        
        $this->error(function () {
            $this->caller->error($this);
        });
        
        $this->complete(function () {
            $this->close();
        });
        
        parent::setURL($this->caller->getCurrentUrl());
        
        if ($referer = $this->caller->getCurrentReferer()) {
            parent::setReferer($referer);
        }
    }
    
    /**
     * @see \Curl\Curl::post()
     */
    public function post($url, $data = array(), $follow_303_with_post = false)
    {
        if (is_array($url)) {
            $data = $url;
            $url = $this->baseUrl;
        }
        
        $this->postData = $data;
        
        $this->setURL($url);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'POST');
        $this->setOpt(CURLOPT_POST, true);
        $this->setOpt(CURLOPT_POSTFIELDS, $this->buildPostData($data));
        
        return $this->exec();
    }
    
    /**
     * @return array
     */
    public function getPostData()
    {
        return $this->postData;
    }
    
}
