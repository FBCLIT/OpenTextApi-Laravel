<?php

namespace Fbcl\OpenTextApi\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Fbcl\OpenTextApi\Laravel\ClientManager;

/**
 * @method static \Fbcl\OpenTextApi\Api api($client = null)
 * @method static \Fbcl\OpenTextApi\Client client($name = null)
 */
class Client extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ClientManager::class;
    }
}
