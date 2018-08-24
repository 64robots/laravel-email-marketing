<?php

namespace R64\LaravelEmailMarketing\MarketingTools;

use R64\LaravelEmailMarketing\Contracts\MarketingTool as MarketingToolContract;
use R64\LaravelEmailMarketing\Exceptions\InvalidConfiguration;
use R64\LaravelEmailMarketing\Integrations\GetResponse;
use R64\LaravelEmailMarketing\MarketingTools\BaseMarketingTool;
use R64\LaravelEmailMarketing\Resources\GetResponseListResource;
use R64\LaravelEmailMarketing\Resources\GetResponseMemberResource;


class GetResponseMarketingTool extends BaseMarketingTool implements MarketingToolContract
{   
    private $grApi;

    private $connected; 

    /**
     * 
     */
    function __construct() {
        $credentials = $this->credentials();
        if (!$credentials) {
            throw new InvalidConfiguration('GetResponse credentials not found in config');
        }
        $this->grApi = new GetResponse($credentials);
        $this->connected = $this->ping();
    }

    /**
     *
     */
    public function getLists() {
        
        $lists = (array)$this->grApi->getCampaigns();
        if (!$lists) {
            return false;
        }

        return GetResponseListResource::collection( collect($lists) );
    }

    /**
     * 
     *
     * @param  string  $listId
     */
    public function getList($listId) {
        $list = $this->grApi->getcampaign($listId);
        if (!$list) {
            return false;
        }
        return new GetResponseListResource($list);
    }

    /**
     * 
     *
     * @param  string  $listId
     */
    public function getListSubscribers($listId) {
        $listMembers = $this->grApi->getContacts([
            'query[campaignId]' => $listId
        ]);
        if (!$listMembers) {
            return false;
        }

        return GetResponseMemberResource::collection(collect($listMembers));
    }

    public function getSubscribers() {
        $listMembers = $this->grApi->getContacts();
        if (!$listMembers) {
            return false;
        }

        return GetResponseMemberResource::collection(collect($listMembers));
    }

    public function isConnected() {
        return $this->connected;
    }
    
    private function ping() {
        return $this->grApi->ping();
    }

    private function credentials()
    {
        if ($this->marketingToolExists()) {
            return $this->marketingTool()['api_key'];
        }
    }
}
