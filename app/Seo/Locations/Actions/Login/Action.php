<?php

namespace App\Seo\Locations\Actions\Login;

use App\Seo\Locations\Actions\Action as BaseAction;
use App\Jobs\JobMaker;
use App\LoginReportAction;
use App\LoginReportActionLog;
use App\Seo\Locations\Responses\Response;
use Carbon\Carbon;

abstract class Action extends BaseAction
{
    use JobMaker;
    
    /**
     * @return void
     */
    protected function finalLog()
    {
        if ($this->isFinished()) {
            
            $report = $this->location->getReport();
            $link = $this->location->getLink();
            
            $seconds = $report->getSecondsBetweenActions();
            
            $report->update([
                'is_success' => ! $report->areLastActionsFailed(3),
                'is_finished' => true,
                'avg_seconds_between_actions' => $seconds->avg(),
                'max_seconds_between_actions' => $seconds->max(),
            ]);
            
            $update = [
                'login_total_done' => $link->loginReports()->whereNotNull('is_success')->whereRepeatMode(false)->count(),
                'login_total_success' => $link->loginReports()->whereIsSuccess(true)->whereRepeatMode(false)->count(),
                'login_total_failed' => $link->loginReports()->whereIsSuccess(false)->whereRepeatMode(false)->count(),
            ];
            
            if ( ! $report->isRepeatMode()) {
                $update['login_last_failed'] = $report->is_success ? 0 : $link->login_last_failed + 1;
            }
            
            $link->update($update);
        }
    }
    
    /**
     * @see \App\Seo\Locations\Actions\Action::log()
     */
    protected function log($isSuccess, \Exception $e = null)
    {
        \DB::transaction(function () use ($isSuccess, $e) {
            
            $action = new \stdClass();
            $action->name = $this->getActionName();
            $action->is_success = $isSuccess;
            $action->done_at = Carbon::now()->timestamp;
            if ($e) {
                $action->exception_number = $e->getCode();
                $action->exception_message = $e->getMessage();
            }
            
            $report = $this->location->getReport();
            $report->update([
                'actions' => $report->actions->push($action),
            ]);
            
            $reportAction = $report->reportActions()->save(
                (new LoginReportAction)->fillFromAction($this, $isSuccess, $e)
            );
            
        });
    }
    
    /**
     * @return void
     */
    protected function jobLogin()
    {
        if ( ! $this->isFinished()) {
            self::dispatchLocationLoginJob($this->location->getReport(), config('seo.action_login_break_between_actions'));
        }
    }
    
    /**
     * @return void
     */
    protected function jobVisitAfterLogin()
    {
        if ( ! $this->isFinished()) {
            self::dispatchLocationVisitAfterLoginJob($this->location->getReport(), config('seo.action_login_break_between_actions'));
        }
    }
    
    /**
     * @see \App\Seo\Locations\Actions\Action::isFinished()
     */
    protected function isFinished()
    {
        $isFinished = parent::isFinished();
        
        if ( ! $isFinished) {
            return  $this->location->getActionCount() >= config('seo.action_login_run_per_day') ||
                    $this->location->getReport()->areLastActionsFailed(5);
        }
        
        return $isFinished;
    }
    
}
