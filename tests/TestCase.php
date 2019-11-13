<?php
namespace Ankurk91\Tests\LaravelStripeExceptions;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [\Ankurk91\StripeExceptions\StripeServiceProvider::class];
    }
}
