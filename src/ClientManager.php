<?php

namespace Fbcl\OpenTextApi\Laravel;

use Fbcl\OpenTextApi\Client;
use InvalidArgumentException;

class ClientManager
{
    /**
     * The current application.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * An array of created "clients".
     *
     * @var array
     */
    protected $clients = [];

    /**
     * The callable to be executed to connect to the OpenText API.
     *
     * @var callable
     */
    protected $connector;

    /**
     * Constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;

        $this->connector = function ($client, $config) {
            $client->connect($config['username'], $config['password']);
        };
    }

    /**
     * Attempt to get the client from the local cache.
     *
     * @param null|string $name
     *
     * @return Client
     */
    public function client($name = null)
    {
        $name = $name ?: $this->getDefaultClient();

        return $this->clients[$name] ?? $this->clients[$name] = $this->resolve($name);
    }

    /**
     * Attempt to get the clients API.
     *
     * @param null|string $client
     *
     * @return \Fbcl\OpenTextApi\Api
     */
    public function api($client = null)
    {
        return $this->client($client)->api();
    }

    /**
     * Set the connector to establish a connection with the OpenText API.
     *
     * @param callable $connector
     *
     * @return $this
     */
    public function setConnector(callable $connector)
    {
        $this->connector = $connector;

        return $this;
    }

    /**
     * Resolve the given client name.
     *
     * @param string $name
     *
     * @return Client
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);

        if (is_null($config)) {
            throw new InvalidArgumentException("OpenText client [{$name}] is not defined.");
        }

        call_user_func($this->connector, $client = new Client($config['url']), $config);

        return $client;
    }

    /**
     * Get the configuration for the given client.
     *
     * @param string $name
     *
     * @return mixed
     */
    protected function getConfig($name)
    {
        return $this->app['config']["opentext.clients.{$name}"];
    }

    /**
     * Get the default client name.
     *
     * @return string
     */
    protected function getDefaultClient()
    {
        return $this->app['config']['opentext.default'];
    }

    /**
     * Dynamically call the default client instance.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->client()->{$method}(...$parameters);
    }
}
