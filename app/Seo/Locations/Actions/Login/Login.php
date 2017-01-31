<?php

namespace App\Seo\Locations\Actions\Login;

use App\Exceptions\SeoException;
use App\Exceptions\Location\IsLoggedInException;
use App\Exceptions\Location\HasNotUrlForIndexationException;

class Login extends Action
{
    
    /**
     * @see \App\Seo\Locations\Actions\Action::setActionName()
     */
    protected function setActionName()
    {
        $this->actionName = 'login';
    }
    
    /**
     * @return void
     */
    public function run()
    {
        try {
            
            $this->setFinished(false);
            
            $this->location->getProfile(false);
                $this->location->expectedHasLink();
            
            $this->location->getForumHome();
                $this->location->expectedIsNotLoggedIn();
            
            $this->location->getLogin();
            
            sleep(3);
            
            $this->location->postLogin();
            
            $this->location->getProfile();
                $this->location->expectedIsLoggedIn();
            
            $this->location->getForumHome(false);
                $this->location->expectedHasProfileUrl();
            
            $this->success();
            
        } catch (IsLoggedInException $e) {
            
            $this->success($e);
            
        } catch (HasNotUrlForIndexationException $e) {
            
            $this->logError($e);
            $this->jobVisitAfterLogin();
            
        } catch (SeoException $e) {
            
            $this->logError($e);
            $this->jobLogin();
            
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
