<?php
declare(strict_types=1);

namespace Ankurk91\StripeExceptions\Tests;

use Ankurk91\StripeExceptions\StripeServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(StripeServiceProvider::class)]
class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            StripeServiceProvider::class,
        ];
    }
}
