<?php

namespace Fbcl\OpenTextApi\Laravel\Tests;

use Fbcl\OpenTextApi\Laravel\OpenTextServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [OpenTextServiceProvider::class];
    }
}
