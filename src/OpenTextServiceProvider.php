<?php

namespace Fbcl\OpenTextApi\Laravel;

use Illuminate\Support\ServiceProvider;

class OpenTextServiceProvider extends ServiceProvider
{
    /**
     * Register OpenText application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/opentext.php' => config_path('opentext.php'),
            ]);
        }

        $this->app->singleton(ClientManager::class, function ($app) {
            return new ClientManager($app);
        });
    }
}
