<?php

namespace App\Jobs;

use App\CheckReport;
use App\LoginReport;

trait JobMaker
{
    /**
     * @param number $delayMinutes
     * @return void
     */
    public static function dispatchCronJob($delayMinutes = 0)
    {
        dispatch(
            (new Cron())
                ->onQueue('cron')
                ->delay(60 * $delayMinutes)
        );
    }
    
    /**
     * @param CheckReport $checkReport
     * @param number $delayMinutes
     * @return void
     */
    public static function dispatchLocationCheckJob(CheckReport $checkReport, $delayMinutes = 0)
    {
        dispatch(
            (new LocationCheck($checkReport->id))
                ->onQueue($checkReport->link->queueCheck())
                ->delay(60 * $delayMinutes)
        );
    }
    
    /**
     * @param LoginReport $loginReport
     * @param number $delayMinutes
     * @return void
     */
    public static function dispatchLocationLoginJob(LoginReport $loginReport, $delayMinutes = 0)
    {
        dispatch(
            (new LocationLogin($loginReport->id))
                ->onQueue($loginReport->link->queueLogin())
                ->delay(60 * $delayMinutes)
        );
    }
    
    /**
     * @param LoginReport $loginReport
     * @param unknown $delayMinutes
     * @return void
     */
    public static function dispatchLocationVisitAfterLoginJob(LoginReport $loginReport, $delayMinutes = 3)
    {
        dispatch(
            (new LocationVisitAfterLogin($loginReport->id))
                ->onQueue($loginReport->link->queueVisitAfterLogin())
                ->delay(60 * $delayMinutes)
        );
    }
    
}
