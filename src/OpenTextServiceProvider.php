<?php

namespace Fbcl\OpenTextApi\Laravel;

use Fbcl\OpenTextApi\Api;
use Fbcl\OpenTextApi\Client;
use Illuminate\Support\ServiceProvider;

class OpenTextServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/opentext.php' => config_path('opentext.php'),
            ]);
        }

        $this->app->singleton(Client::class, function () {
            return new Client(config('opentext.url'));
        });

        $this->app->singleton(Api::class, function () {
            return app(Client::class)->connect(
                config('opentext.username'),
                config('opentext.password')
            );
        });
    }
}
