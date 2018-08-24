<?php

namespace R64\LaravelEmailMarketing\MarketingTools;

use R64\LaravelEmailMarketing\Contracts\MarketingTool as MarketingToolContract;
use R64\LaravelEmailMarketing\Exceptions\InvalidConfiguration;
use R64\LaravelEmailMarketing\MarketingTools\BaseMarketingTool;
use Exception;

class MarketingToolManager extends BaseMarketingTool implements MarketingToolContract
{
    /**
     * Associative array to map from the config selected tool to the tool's class
     */
    const TOOL_CLASSES = [
        'activecampaign' => \R64\LaravelEmailMarketing\MarketingTools\ActiveCampaignMarketingTool::class,
        'getresponse' => \R64\LaravelEmailMarketing\MarketingTools\GetResponseMarketingTool::class,
        'mailchimp' => \R64\LaravelEmailMarketing\MarketingTools\MailchimpMarketingTool::class
    ];

    private $marketingTool;

    private $connected;

    /**
     * Initailize the selected tool's class and check connection status
     */
    function __construct() {
        if (!$this->marketingToolExists()) {
            throw new InvalidConfiguration('Marketing tool not found in config');
        }
        $toolClass = self::TOOL_CLASSES[config('email-marketing.tool')];
        $this->marketingTool = new $toolClass;
    
        $this->connected = $this->marketingTool->isConnected();
    }

     /**
     * Retrieve all lists
     * 
     * @return array
     */
    public function getLists() {
        return $this->marketingTool->getLists();
    }

    /**
     * Retrieve list with listId
     *
     * @param  string  $listId
     * @return array
     */
    public function getList($listId) {
        return $this->marketingTool->getList($listId);
    }

    /**
     * Retrieve subscribers from list with listId
     *
     * @param  string  $listId
     * @return array
     */
    public function getListSubscribers($listId) {
        return $this->marketingTool->getListSubscribers($listId);
    }

    /**
     * Retrieve all subscribers
     * 
     * @return array
     */
    public function getSubscribers() {
        return $this->marketingTool->getSubscribers();
    }

    /**
     * Retrieve the connection status
     * 
     * @return bool
     */
    public function isConnected() {
        return $this->connected;
    }
}
