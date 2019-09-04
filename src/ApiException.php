<?php

namespace Ankurk91\StripeExceptions;

use Illuminate\Support\Facades\Response;
use Stripe\Exception;
use Illuminate\Support\Facades\Lang;

class ApiException extends AbstractException
{
    /**
     * {@inheritdoc}
     */
    protected $dontReport = [
        Exception\ApiConnectionException::class,
        Exception\CardException::class,
        Exception\IdempotencyException::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function render($request)
    {
        $e = $this->getPrevious();
        $message = Lang::get('stripe::exceptions.api.unknown');
        $errorCode = 500;

        // https://stripe.com/docs/api/errors/handling?lang=php
        if ($e instanceof Exception\CardException) {
            $errorCode = 400;
            $message = data_get($e->getJsonBody(), 'error.message', Lang::get('stripe::exceptions.api.invalid_card'));
        } elseif ($e instanceof Exception\RateLimitException) {
            $message = Lang::get('stripe::exceptions.api.rate_limit');
        } elseif ($e instanceof Exception\InvalidRequestException) {
            $errorCode = 400;
            $message = Lang::get('stripe::exceptions.api.invalid_request');
        } elseif ($e instanceof Exception\AuthenticationException) {
            $message = Lang::get('stripe::exceptions.api.authentication');
        } elseif ($e instanceof Exception\ApiConnectionException) {
            $message = Lang::get('stripe::exceptions.api.connection');
        } elseif ($e instanceof Exception\ApiErrorException) {
            $message = Lang::get('stripe::exceptions.api.general');
        }

        return Response::json(compact('message'), $errorCode);
    }
}
