<?php

namespace R64\LaravelEmailMarketing\MarketingTools;

use \ActiveCampaign;
use R64\LaravelEmailMarketing\Contracts\MarketingTool as MarketingToolContract;
use R64\LaravelEmailMarketing\Exceptions\InvalidConfiguration;
use R64\LaravelEmailMarketing\MarketingTools\BaseMarketingTool;
use R64\LaravelEmailMarketing\Resources\MailchimpListResource;
use R64\LaravelEmailMarketing\Resources\MailchimpMemberResource;

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
        $lists = $this->acApi->api('list/list');
        dd($lists);
        if (!$lists) {
            return false;
        }
        return MailchimpListResource::collection(collect($lists['lists']));
    }

    /**
     * 
     *
     * @param  string  $listId
     */
    public function getList($listId) {
        $list = $this->mailchimpApi->get('lists/' . $listId);
        if (!$list) {
            return false;
        }

        return new MailchimpListResource($list);
    }

    /**
     * 
     *
     * @param  string  $listId
     */
    public function getListMembers($listId) {
        $listMembers = $this->mailchimpApi->get('lists/' . $listId . '/members');
        if (!$listMembers) {
            return false;
        }

        return MailchimpMemberResource::collection(collect($listMembers['members']));
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
}
