<?php

namespace App\Seo\Contracts;

interface ReportModel
{
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function link();
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reportActions();
    
    /**
     * @return bool
     */
    public function isRepeatMode();
    
}
