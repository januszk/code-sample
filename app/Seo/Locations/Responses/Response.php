<?php

namespace App\Seo\Locations\Responses;

use App\Seo\Curl;
use Carbon\Carbon;

class Response
{
    
    /**
     * @var Curl
     */
    protected $curl;
    
    /**
     * @var int
     */
    protected $stepCount;
    
    /**
     * @var string
     */
    protected $stepName;
    
    /**
     * @var string
     */
    protected $url;
    
    /**
     * @var string
     */
    protected $referer;
    
    /**
     * @var \Carbon\Carbon
     */
    protected $doneAt;
    
    
    
    /**
     * @param Curl $curl
     * @param int $stepCount
     * @param string $stepName
     * @param string $url
     * @param string $referer
     * @return void
     */
    public function __construct(Curl $curl, $stepCount, $stepName, $url, $referer)
    {
        $this->curl = $curl;
        
        $this->stepCount = $stepCount;
        
        $this->stepName = $stepName;
        
        $this->url = $url;
        
        $this->referer = $referer;
        
        $this->doneAt = Carbon::now();
    }
    
    /**
     * @return int
     */
    public function getStepCount()
    {
        return $this->stepCount;
    }
    
    /**
     * @return string
     */
    public function getStepName()
    {
        return $this->stepName;
    }
    
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }
    
    /**
     * @return string
     */
    public function getResponseHtml()
    {
        return $this->curl->response;
    }
    
    /**
     * @return int
     */
    public function getResponseHttpCode()
    {
        return $this->curl->httpStatusCode;
    }
    
    /**
     * @return array
     */
    public function getPostData()
    {
        return $this->curl->getPostData();
    }
    
    /**
     * @return \Carbon\Carbon
     */
    public function getDoneAt()
    {
        return $this->doneAt;
    }
    
}
