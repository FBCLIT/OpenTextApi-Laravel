<?php

namespace Fbcl\OpenTextApi\Laravel\Tests;

use Fbcl\OpenTextApi\Api;
use Fbcl\OpenTextApi\Client;
use Fbcl\OpenTextApi\Laravel\OpenTextServiceProvider;
use GuzzleHttp\Exception\ConnectException;

class OpenTextClientTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('opentext.url', 'url');
        $app['config']->set('opentext.username', 'user');
        $app['config']->set('opentext.password', 'secret');
    }

    public function test_client_is_registered_as_singleton()
    {
        $client = app(Client::class);
        $this->assertInstanceof(Client::class, $client);
        $this->assertEquals('url/api/v1/', $client->getBaseUrl());
        $this->assertEquals('url', $client->getUrl());
    }

    public function test_config_is_publishable()
    {
        $this->artisan('vendor:publish', ['--provider' => OpenTextServiceProvider::class, '--no-interaction' => true]);

        $this->assertFileExists(config_path('opentext.php'));
    }

    public function test_api_is_resolved_and_throws_exception_due_to_invalid_url()
    {
        $this->expectException(ConnectException::class);

        app(Api::class);
    }
}
