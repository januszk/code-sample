<?php

namespace App\Seo\Repositories;

use App\Link;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ScheduleRepository
{
    /**
     * @return Collection
     */
    public function getLinksForCheck()
    {
        return Link::whereHas('location.cms', function ($query) {
                        $query->whereActiveCheck(1);
                    })
                    ->whereHas('project', function ($query) {
                        $query->whereActiveCheck(1);
                    })
                    ->where(function ($query) {
                        $query
                            ->whereNull('parent_link_id')
                            ->orWhereHas('parentLink', function ($query) {
                                $query
                                    ->where('check_total_done', '>', 0)
                                    ->whereCheckLastFailed(0);
                            });
                    })
                    ->whereNotNull('check_availabled_at')
                    ->whereNotNull('login_availabled_at')
                    ->where('check_availabled_at', '<=', Carbon::today())
                    ->limit(config('seo.cron_schedule_check_limit'))
                    ->get();
    }
    
    /**
     * @return Collection
     */
    public function getLinksForLogin()
    {
        return Link::whereHas('location.cms', function ($query) {
                        $query->whereActiveLogin(1);
                    })
                    ->whereHas('project', function ($query) {
                        $query->whereActiveLogin(1);
                    })
                    ->where(function ($query) {
                        $query
                            ->whereNull('parent_link_id')
                            ->orWhereHas('parentLink', function ($query) {
                                $query
                                    ->where('check_total_done', '>', 0)
                                    ->whereCheckLastFailed(0);
                            });
                    })
                    ->where('check_total_done', '>', 0)
                    ->whereCheckLastFailed(0)
                    ->whereNotNull('login_availabled_at')
                    ->where('login_availabled_at', '<=', Carbon::today())
                    ->limit(config('seo.cron_schedule_login_limit'))
                    ->orderBy('location_id', (Carbon::now()->day % 2 ? 'asc' : 'desc'))
                    ->get();
    }
    
}
