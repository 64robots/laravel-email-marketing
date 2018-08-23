<?php

namespace R64\LaravelEmailMarketing\MarketingTools;

use R64\LaravelEmailMarketing\Contracts\MarketingTool as MarketingToolContract;
use R64\LaravelEmailMarketing\Exceptions\InvalidConfiguration;
use R64\LaravelEmailMarketing\MarketingTools\BaseMarketingTool;
use R64\LaravelEmailMarketing\Resources\MailchimpListResource;
use R64\LaravelEmailMarketing\Transformers\MailchimpListTransformer;

class MailchimpMarketingTool extends BaseMarketingTool implements MarketingToolContract
{   
    private $mailchimpApi;

    private $connected; 

    /**
     * 
     */
    function __construct() {
        $apiKey = $this->credentials();
        if (!$apiKey) {
            throw new InvalidConfiguration('MailChimp credentials not found in config');
        }
        $this->mailchimpApi = new \DrewM\MailChimp\MailChimp($apiKey);
        $this->connected = $this->ping();
    }

    /**
     *
     */
    public function getLists() {
        $lists = $this->mailchimpApi->get('lists');
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

        return $list;
    }

    /**
     * 
     *
     * @param  string  $listId
     */
    public function getListMembers($listId) {
        $list = $this->mailchimpApi->get('lists/' . $listId . '/members');
        if (!$list) {
            return false;
        }

        return $list;
    }

    
    public function createList() {

    }

    public function isConnected() {
        return $this->connected;
    }
    
    private function ping() {
        return $this->mailchimpApi->get('ping') ? true : false;
    }

    private function credentials()
    {
        if ($this->marketingToolExists()) {
            return $this->marketingTool()['api_key'];
        }
    }
}
