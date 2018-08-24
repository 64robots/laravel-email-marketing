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
     * Initailize the ActiveCampaign API
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
     * Retrieve all lists for the connected ActiveCampaign account
     *
     * @return R64\LaravelEmailMarketing\Resources\ActiveCampaignListResource
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
     * Retrieve a specific list with id $listId for the connected ActiveCampaign account
     *
     * @param  string  $listId
     * @return R64\LaravelEmailMarketing\Resources\ActiveCampaignListResource
     */
    public function getList($listId) {
        $list = $this->acApi->api('list/view?id=' . $listId);
        if (!$list) {
            return false;
        }
        return new ActiveCampaignListResource($list);
    }

    /**
     * Retrieve subscribers for a list with id $listId for the connected ActiveCampaign account
     *
     * @param  string  $listId
     * @return R64\LaravelEmailMarketing\Resources\ActiveCampaignMemberResource
     */
    public function getListSubscribers($listId) {
        return $this->getContacts('filters[listId]=' . $listId);
    }

    /**
     * Retrieve all subscribers for the connected ActiveCampaign account
     *
     * @return R64\LaravelEmailMarketing\Resources\ActiveCampaignMemberResource
     */
    public function getSubscribers() {
        return $this->getContacts('ids=all');
    }

    /**
     * Get the connection status
     *
     * @return bool
     */
    public function isConnected() {
        return $this->connected;
    }

    /**
     * Retrieve the ActiveCampaign API credentials from the config
     * 
     * @return array
     */ 
    private function credentials()
    {
        if ($this->marketingToolExists()) {
            return $this->marketingTool();
        }
    }
        
    /**
     * Retrieve a list of contacts using the specified $params for the connected ActiveCampaign account
     *
     * @param  string  $params
     * @return R64\LaravelEmailMarketing\Resources\ActiveCampaignMemberResource
     */
    private function getContacts($params) {
        $listMembers = $this->acApi->api('contact/list?' . $params);
        if (!$listMembers) {
            return false;
        }

        $realMembers = $this->getRealData($listMembers);
        return ActiveCampaignMemberResource::collection(collect($realMembers));
    }

    /**
     * Strip out the unneeded data from the ActiveCampaign response
     *
     * @param  object $data
     * @return array
     */
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

    private function ping() 
    {
        return true;
    }
}
