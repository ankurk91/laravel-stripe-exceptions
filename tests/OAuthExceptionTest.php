<?php

namespace Ankurk91\Tests\LaravelStripeExceptions;

use Illuminate\Http\Request;
use Orchestra\Testbench\TestCase;
use Ankurk91\StripeExceptions\OAuthException;

class OAuthExceptionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testItReturnResponse()
    {
        $exception = new OAuthException(
            new \Stripe\Exception\OAuth\InvalidRequestException("Invalid Request"),
            'errorPage'
        );
        $response = $exception->render(new Request());

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertTrue($response->isRedirect());
        $this->assertEquals($response->getTargetUrl(), "http://localhost/errorPage");
    }

    public function testItShouldReport()
    {
        $originalException = new \Stripe\Exception\OAuth\InvalidClientException();
        $exception = new OAuthException($originalException, "error");
        $this->assertFalse($exception->shouldNotReport($originalException));
    }

    public function testItShouldNotReport()
    {
        $originalException = new \Stripe\Exception\OAuth\InvalidGrantException();
        $exception = new OAuthException($originalException, "error");
        $this->assertTrue($exception->shouldNotReport($originalException));
    }
}
