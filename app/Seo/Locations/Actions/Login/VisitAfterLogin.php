<?php

namespace App\Seo\Locations\Actions\Login;

use App\Exceptions\SeoException;
use App\Exceptions\Location\IsNotLoggedInException;
use App\Exceptions\Location\HasNotUrlForIndexationException;

class VisitAfterLogin extends Action
{
    
    /**
     * @see \App\Seo\Locations\Actions\Action::setActionName()
     */
    protected function setActionName()
    {
        $this->actionName = 'visitAfterLogin';
    }
    
    /**
     * @return void
     */
    public function run()
    {
        try {
            
            $this->setFinished(false);
            
            $this->location->getForumHome();
                $this->location->expectedIsLoggedIn();
            
            $this->location->getForumHome(false);
                $this->location->expectedHasProfileUrl();
            
            $this->success();
            
        } catch (IsNotLoggedInException $e) {
            
            $this->logError($e);
            $this->jobLogin();
            
        } catch (HasNotUrlForIndexationException $e) {
            
            $this->logError($e);
            $this->jobVisitAfterLogin();
            
        } catch (SeoException $e) {
            
            $this->logError($e);
            $this->jobVisitAfterLogin();
            
        } finally {
            
            $this->finalLog();
            
        }
    }
    
    /**
     * @see \App\Seo\Locations\Actions\Action::success()
     */
    protected function success(\Exception $e = null)
    {
        $this->logSuccess($e);
        
        $this->jobVisitAfterLogin();
    }
    
}
