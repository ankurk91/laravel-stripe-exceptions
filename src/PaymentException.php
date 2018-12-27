<?php

namespace LaravelExceptions\Stripe;

use Stripe\Error;

class PaymentException extends Base
{
    /**
     * A list of the exception types that not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        Error\ApiConnection::class,
        Error\Card::class,
        Error\Idempotency::class,
    ];

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        $e = $this->getPrevious();
        $message = 'Something went wrong.';
        $errorCode = 500;

        // https://stripe.com/docs/api/errors/handling?lang=php
        if ($e instanceof Error\Card) {
            $errorCode = 400;
            $message = data_get($e->getJsonBody(), 'error.message', 'Invalid card.');
        } elseif ($e instanceof Error\RateLimit) {
            $message = 'Too many requests. Please try again later.';
        } elseif ($e instanceof Error\InvalidRequest) {
            $errorCode = 400;
            $message = 'Invalid payment request.';
        } elseif ($e instanceof Error\Authentication) {
            $message = 'Error authenticating with payment gateway.';
        } elseif ($e instanceof Error\ApiConnection) {
            $message = 'Error communicating payment gateway.';
        } elseif ($e instanceof Error\Base) {
            $message = 'Unable to proceed with payment at this moment.';
        }

        return response()->json(compact('message'), $errorCode);
    }
}
