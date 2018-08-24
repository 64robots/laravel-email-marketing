<?php

namespace R64\LaravelEmailMarketing;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use R64\LaravelEmailMarketing\MarketingTools\MarketingToolManager;

class EmailMarketingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }

        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/email-marketing.php', 'email-marketing');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Console\TestEmailMarketingCommand::class
        ]);

        $this->app->singleton('R64\LaravelEmailMarketing\MarketingTools\MarketingToolManager', function ($app) {
            return new MarketingToolManager;
        });
    }
    
    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/email-marketing.php' => config_path('email-marketing.php'),
        ], 'email-marketing');
    }
}
