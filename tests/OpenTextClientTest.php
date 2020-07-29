<?php

namespace Fbcl\OpenTextApi\Laravel\Tests;

use Fbcl\OpenTextApi\Laravel\ClientManager;
use Fbcl\OpenTextApi\Laravel\Facades\Client;
use Fbcl\OpenTextApi\Laravel\OpenTextServiceProvider;
use GuzzleHttp\Exception\ConnectException;

class OpenTextClientTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('opentext.default', 'default');
        $app['config']->set('opentext.clients.default.url', 'url');
        $app['config']->set('opentext.clients.default.username', 'user');
        $app['config']->set('opentext.clients.default.password', 'secret');
    }

    public function test_client_is_registered_as_singleton()
    {
        $client = Client::getFacadeRoot();
        $client->setConnector(function () {});
        $this->assertInstanceof(ClientManager::class, $client);
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

        Client::api();
    }
}
