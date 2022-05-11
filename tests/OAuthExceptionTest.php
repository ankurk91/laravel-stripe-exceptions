<?php
declare(strict_types=1);

namespace Ankurk91\StripeExceptions\Tests;

use Ankurk91\StripeExceptions\OAuthException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

class OAuthExceptionTest extends TestCase
{
    public function testItReturnResponse()
    {
        $stripeException = new \Stripe\Exception\OAuth\InvalidRequestException("Invalid Request");
        $stripeException->setStripeCode('invalid_client');
        $exception = new OAuthException($stripeException,'errorPage');
        $response = $exception->render(new Request());

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertTrue($response->isRedirect());
        $this->assertEquals(session()->get('error'), Lang::get('stripe::exceptions.oauth.invalid_request'));
        $this->assertEquals(session()->get('stripe_code'), $stripeException->getStripeCode());
        $this->assertEquals($response->getTargetUrl(), "http://localhost/errorPage");
    }

    public function testItShouldReport()
    {
        $stripeException = new \Stripe\Exception\OAuth\InvalidClientException();
        $exception = new OAuthException($stripeException, "errorPage");
        $this->assertTrue($exception->shouldReport($stripeException));

        $handler = $this->app->make(\Illuminate\Foundation\Exceptions\Handler::class);
        Log::shouldReceive('log')->once();
        $handler->report($exception);
    }

    public function testItShouldNotReport()
    {
        $originalException = new \Stripe\Exception\OAuth\InvalidGrantException();
        $exception = new OAuthException($originalException, "error");
        $this->assertFalse($exception->shouldReport($originalException));

        $handler = $this->app->make(\Illuminate\Foundation\Exceptions\Handler::class);
        Log::shouldReceive('log')->never();
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
