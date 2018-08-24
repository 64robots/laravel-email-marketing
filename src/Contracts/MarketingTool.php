<?php

namespace R64\LaravelEmailMarketing\Contracts;

interface MarketingTool
{
    /**
     * Retrieve all lists
     */
    function getLists();

    /**
     * Retrieve list with listId
     *
     * @param  string  $listId
     */
    function getList($listId);

    /**
     * Retrieve subscribers from list with listId
     *
     * @param  string  $listId
     */
    function getListSubscribers($listId);

    /**
     * Retrieve all subscribers
     */
    function getSubscribers();

    /**
     * Retrieve the connection status
     */
    function isConnected();
}