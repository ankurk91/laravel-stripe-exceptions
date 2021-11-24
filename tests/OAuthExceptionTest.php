<?php

namespace Ankurk91\Tests\LaravelStripeExceptions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Ankurk91\StripeExceptions\OAuthException;

class OAuthExceptionTest extends TestCase
{
    public function testItReturnResponse()
    {
        $exception = new OAuthException(
            new \Stripe\Exception\OAuth\InvalidRequestException("Invalid Request"),
            'errorPage'
        );
        $response = $exception->render(new Request());

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertTrue($response->isRedirect());
        $this->assertEquals(session()->get('error'), Lang::get('stripe::exceptions.oauth.invalid_request'));
        $this->assertEquals($response->getTargetUrl(), "http://localhost/errorPage");
    }

    public function testItShouldReport()
    {
        $originalException = new \Stripe\Exception\OAuth\InvalidClientException();
        $exception = new OAuthException($originalException, "error");
        $this->assertTrue($exception->shouldReport($originalException));

        $handler = $this->app->make(\Illuminate\Foundation\Exceptions\Handler::class);
        Log::shouldReceive('error')->once();
        $handler->report($exception);
    }

    public function testItShouldNotReport()
    {
        $originalException = new \Stripe\Exception\OAuth\InvalidGrantException();
        $exception = new OAuthException($originalException, "error");
        $this->assertFalse($exception->shouldReport($originalException));

        $handler = $this->app->make(\Illuminate\Foundation\Exceptions\Handler::class);
        Log::shouldReceive('error')->never();
        $handler->report($exception);
    }

    public function testUnknownException()
    {
        $exception = new OAuthException(
            new \Exception(),
            'errorPage'
        );
        $response = $exception->render(new Request());
        $this->assertEquals(session()->get('error'), Lang::get('stripe::exceptions.oauth.unknown'));
    }
}
