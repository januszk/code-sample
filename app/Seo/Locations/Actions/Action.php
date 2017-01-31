<?php

namespace App\Seo\Locations\Actions;

use App\Seo\Locations\Location;

abstract class Action
{
    
    /**
     * @var Location
     */
    protected $location;
    
    /**
     * @var string
     */
    protected $actionName;
    
    /**
     * @var bool
     */
    protected $finished = null;
    
    
    
    /**
     * @param Location $location
     * @return void
     */
    public function __construct(Location $location)
    {
        $this->location = $location;
        
        $this->setActionName();
    }
    
    
    
    abstract protected function setActionName();
    
    abstract protected function success(\Exception $e = null);
    
    abstract protected function log($isSuccess, \Exception $e = null);
    
    /**
     * @param \Exception $e
     * @return void
     */
    protected function logSuccess(\Exception $e = null)
    {
        $this->log(true, $e);
    }
    
    /**
     * @param \Exception $e
     * @return void
     */
    protected function logError(\Exception $e = null)
    {
        $this->log(false, $e);
    }
    
    /**
     * @return string
     */
    public function cookieFile()
    {
        $path = storage_path() .
                    DIRECTORY_SEPARATOR .
                config('seo.curl_cookie_storage_path') .
                    DIRECTORY_SEPARATOR .
                $this->location->getLink()->project->id;
        
        if ( ! \File::exists($path))
        {
            \File::makeDirectory($path, 0777, true);
        }
        
        return $path .
                    DIRECTORY_SEPARATOR .
                $this->location->getLink()->id . config('seo.curl_cookie_extension');
    }
    
    /**
     * @return \App\Seo\Locations\Location
     */
    public function getLocation()
    {
        return $this->location;
    }
    
    /**
     * @return string
     */
    public function getActionName()
    {
        return $this->actionName;
    }
    
    /**
     * @param bool $finished
     * @return void
     */
    protected function setFinished($finished)
    {
        $this->finished = $finished;
    }
    
    /**
     * @throws \Exception
     * @return bool
     */
    protected function isFinished()
    {
        if ( ! is_bool($this->finished)) {
            throw new \Exception('Finished is not set or is not bool type');
        }
        
        return $this->finished;
    }
    
}
