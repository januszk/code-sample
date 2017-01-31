<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\LoginReport;

class LocationVisitAfterLogin extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    /**
     * @var int
     */
    protected $loginReportId;
    
    
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($loginReportId)
    {
        $this->loginReportId = $loginReportId;
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $loginReport = LoginReport::findOrFail($this->loginReportId);
        
        $link = $loginReport->link;
        
        $className = buildLocationClassName($link);
        
        $location = new $className($link, $loginReport);
        
        $location->visitAfterLogin();
    }
    
}
