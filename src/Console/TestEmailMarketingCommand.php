<?php

namespace R64\LaravelEmailMarketing\Console;

use Illuminate\Console\Command;
use R64\LaravelEmailMarketing\MarketingTools\MarketingToolManager;

class TestEmailMarketingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email-marketing:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new field';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $marketingToolManager = new MarketingToolManager;
        dd($marketingToolManager->getLists());
    }

}
