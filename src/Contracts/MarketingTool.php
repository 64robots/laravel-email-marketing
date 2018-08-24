<?php

namespace R64\LaravelEmailMarketing\Contracts;

interface MarketingTool
{
    /**
     * Retrieve all lists
     */
    function getLists();

    /**
     * Retireve list with listId
     *
     * @param  string  $listId
     */
    function getList($listId);

    function getListSubscribers($listId);

    function getSubscribers();

    function isConnected();
}