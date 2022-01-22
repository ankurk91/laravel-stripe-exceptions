<?php
declare(strict_types=1);

namespace Ankurk91\LaravelStripeExceptions\Tests;

use Ankurk91\StripeExceptions\ApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

class ApiExceptionTest extends TestCase
{
    public function testItReturnResponse()
    {
        $exception = new ApiException(new \Stripe\Exception\InvalidRequestException("Invalid Request"));
        $response = $exception->render(new Request());

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(), 400);
        $this->assertEquals($response->getData()->message, Lang::get('stripe::exceptions.api.invalid_request'));
    }

    public function testItShouldReport()
    {
        $originalException = new \Stripe\Exception\InvalidRequestException();
        $exception = new ApiException($originalException);
        $this->assertTrue($exception->shouldReport($originalException));

        $handler = $this->app->make(\Illuminate\Foundation\Exceptions\Handler::class);
        Log::shouldReceive('error')->once();
        $handler->report($exception);
    }

    public function testItShouldNotReport()
    {
        $originalException = new \Stripe\Exception\ApiConnectionException();
        $exception = new ApiException($originalException);
        $this->assertFalse($exception->shouldReport($originalException));

        $handler = $this->app->make(\Illuminate\Foundation\Exceptions\Handler::class);
        Log::shouldReceive('error')->never();
        $handler->report($exception);
    }

    public function testAlwaysReportWhenDebugIsTrue()
    {
        Config::set('app.debug', true);

        $originalException = new \Stripe\Exception\ApiConnectionException();
        $exception = new ApiException($originalException);
        $this->assertTrue($exception->shouldReport($originalException));

        $handler = $this->app->make(\Illuminate\Foundation\Exceptions\Handler::class);
        Log::shouldReceive('error')->once();
        $handler->report($exception);
    }

    public function testCardExceptionJsonBody()
    {
        $originalException = \Stripe\Exception\CardException::factory(
            "Card error",
            400,
            [],
            ['error' => ['message' => 'Your card was declined.']]
        );

        $exception = new ApiException($originalException);
        $response = $exception->render(new Request());
        $this->assertEquals($response->getStatusCode(), 400);
        $this->assertEquals($response->getData()->message, 'Your card was declined.');
    }

    public function testUnknownException()
    {
        $exception = new ApiException(new \Exception());
        $response = $exception->render(new Request());

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(), 500);
        $this->assertEquals($response->getData()->message, Lang::get('stripe::exceptions.api.unknown'));
    }
}
