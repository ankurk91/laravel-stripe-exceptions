<?php
declare(strict_types=1);

namespace Ankurk91\StripeExceptions\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            \Ankurk91\StripeExceptions\StripeServiceProvider::class,
        ];
    }
}
