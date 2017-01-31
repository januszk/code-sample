<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\CheckReport;

class LocationCheck extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    /**
     * @var int
     */
    protected $checkReportId;
    
    
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($checkReportId)
    {
        $this->checkReportId = $checkReportId;
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $checkReport = CheckReport::findOrFail($this->checkReportId);
        
        $link = $checkReport->link;
        
        $className = buildLocationClassName($link);
        
        $location = new $className($link, $checkReport);
        
        $location->check();
    }
    
}
