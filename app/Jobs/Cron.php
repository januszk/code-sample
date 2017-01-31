<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Jobs\JobMaker;
use App\Seo\Schedule\Check;
use App\Seo\Schedule\Login;

class Cron extends Job implements ShouldQueue
{
    use JobMaker;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Check::run();
        Login::run();
        
        self::dispatchCronJob(10);
    }
    
}
