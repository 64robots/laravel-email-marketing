<?php

namespace R64\LaravelEmailMarketing\MarketingTools;

use R64\LaravelEmailMarketing\Contracts\MarketingTool as MarketingToolContract;
use R64\LaravelEmailMarketing\Exceptions\InvalidConfiguration;
use R64\LaravelEmailMarketing\MarketingTools\BaseMarketingTool;
use R64\LaravelEmailMarketing\Resources\MailchimpListResource;
use R64\LaravelEmailMarketing\Resources\MailchimpMemberResource;

class MailchimpMarketingTool extends BaseMarketingTool implements MarketingToolContract
{   
    private $mailchimpApi;

    private $connected; 

    /**
     * Initailize the Mailchimp API and check for successful connection
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
     * Retrieve all lists for the connected Mailchimp account
     * 
     * @return R64\LaravelEmailMarketing\Resources\MailchimpListResource
     */
    public function getLists() {
        $lists = $this->mailchimpApi->get('lists');
        if (!$lists) {
            return false;
        }
        return MailchimpListResource::collection(collect($lists['lists']));
    }

    /**
     * Retrieve a specific list with id $listId for the connected Mailchimp account
     *
     * @param  string  $listId
     * @return R64\LaravelEmailMarketing\Resources\MailchimpListResource
     */
    public function getList($listId) {
        $list = $this->mailchimpApi->get('lists/' . $listId);
        if (!$list) {
            return false;
        }

        return new MailchimpListResource($list);
    }

    /**
     * Retrieve subscribers for a list with id $listId for the connected Mailchimp account
     *
     * @param  string  $listId
     * @return R64\LaravelEmailMarketing\Resources\MailchimpMemberResource
     */
    public function getListSubscribers($listId) {
        $listMembers = $this->mailchimpApi->get('lists/' . $listId . '/members');
        if (!$listMembers) {
            return false;
        }

        return MailchimpMemberResource::collection(collect($listMembers['members']));
    }

    /**
     * Mailchimp has no call to retrieve all subscribers so we just return null
     *
     * @return null
     */
    public function getSubscribers() {
        return null;
    }

    /**
     * Get the connection status as a result of ping()
     *
     * @return bool
     */
    public function isConnected() {
        return $this->connected;
    }
    
    /**
     * Ping the Mailchimp API to verify a successful connection after initializing
     * 
     * @return bool
     */
    private function ping() {
        return $this->mailchimpApi->get('ping') ? true : false;
    }

    /**
     * Retrieve the Mailchimp API credentials from the config
     * 
     * @return string
     */ 
    private function credentials()
    {
        if ($this->marketingToolExists()) {
            return $this->marketingTool()['api_key'];
        }
    }
}
