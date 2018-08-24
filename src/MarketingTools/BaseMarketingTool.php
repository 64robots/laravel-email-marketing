<?php

namespace R64\LaravelEmailMarketing\MarketingTools;

abstract class BaseMarketingTool
{   
    /**
     * Check the config to ensure a valid marketing tool is selected
     * 
     * @return bool
     */
    protected function marketingToolExists() {
        return isset(config('email-marketing.tools')[config('email-marketing.tool')]);
    }

    /**
     * Retrieve the configuration for the selected marketing tool
     * 
     * @return array
     */
    protected function marketingTool() {
        return config('email-marketing.tools')[config('email-marketing.tool')];
    }

}
