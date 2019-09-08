<?php

namespace Ankurk91\Tests\LaravelStripeExceptions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Orchestra\Testbench\TestCase;
use Ankurk91\StripeExceptions\ApiException;

class ApiExceptionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

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
        $this->assertFalse($exception->shouldNotReport($originalException));
    }

    public function testItShouldNotReport()
    {
        $originalException = new \Stripe\Exception\CardException();
        $exception = new ApiException($originalException);
        $this->assertTrue($exception->shouldNotReport($originalException));
    }
}
