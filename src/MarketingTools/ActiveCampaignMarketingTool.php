<?php

namespace R64\LaravelEmailMarketing\MarketingTools;

use R64\LaravelEmailMarketing\Contracts\MarketingTool as MarketingToolContract;
use R64\LaravelEmailMarketing\Exceptions\InvalidConfiguration;
use R64\LaravelEmailMarketing\MarketingTools\BaseMarketingTool;
use R64\LaravelEmailMarketing\Resources\ActiveCampaignListResource;
use R64\LaravelEmailMarketing\Resources\ActiveCampaignMemberResource;

class ActiveCampaignMarketingTool extends BaseMarketingTool implements MarketingToolContract
{   
    private $acApi;

    private $connected; 

    /**
     * 
     */
    function __construct() {
        $credentials = $this->credentials();
        if (!$credentials) {
            throw new InvalidConfiguration('ActiveCampaign credentials not found in config');
        }
        $this->acApi = new \ActiveCampaign($credentials['url'], $credentials['api_key']);
        $this->connected = $this->ping();
    }

    /**
     *
     */
    public function getLists() {
        
        $lists = (array)$this->acApi->api('list/list?ids=all');
        if (!$lists) {
            return false;
        }

        $realLists = $this->getRealData($lists);

        return ActiveCampaignListResource::collection( collect($realLists) );
    }

    /**
     * 
     *
     * @param  string  $listId
     */
    public function getList($listId) {
        $list = $this->acApi->api('list/view?id=' . $listId);
        if (!$list) {
            return false;
        }
        return new ActiveCampaignListResource($list);
    }

    /**
     * 
     *
     * @param  string  $listId
     */
    public function getListMembers($listId) {
        $listMembers = $this->acApi->api('contact/list?filters[listId]=' . $listId);
        if (!$listMembers) {
            return false;
        }

        $realMembers = $this->getRealData($listMembers);
        return ActiveCampaignMemberResource::collection(collect($realMembers));
    }

    
    public function createList() {

    }

    public function isConnected() {
        return $this->connected;
    }
    
    private function ping() {
        return true;
    }

    private function credentials()
    {
        if ($this->marketingToolExists()) {
            return $this->marketingTool();
        }
    }

    private function getRealData($data)
    {
        $realItems = [];
        foreach ($data as $item) {
            if (is_object($item)) {
                $realItems[] = $item;
            }
        }
        return $realItems;
    }
}
