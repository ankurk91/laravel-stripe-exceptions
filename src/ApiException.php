<?php

namespace Ankurk91\StripeExceptions;

use Illuminate\Support\Facades\Response;
use Stripe\Error;
use Illuminate\Support\Facades\Lang;

class ApiException extends AbstractException
{
    /**
     * {@inheritdoc}
     */
    protected $dontReport = [
        Error\ApiConnection::class,
        Error\Card::class,
        Error\Idempotency::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function render($request)
    {
        $e = $this->getPrevious();
        $message = Lang::trans('stripe::exceptions.api.unknown');
        $errorCode = 500;

        // https://stripe.com/docs/api/errors/handling?lang=php
        if ($e instanceof Error\Card) {
            $errorCode = 400;
            $message = data_get($e->getJsonBody(), 'error.message', Lang::trans('stripe::exceptions.api.invalid_card'));
        } elseif ($e instanceof Error\RateLimit) {
            $message = Lang::trans('stripe::exceptions.api.rate_limit');
        } elseif ($e instanceof Error\InvalidRequest) {
            $errorCode = 400;
            $message = Lang::trans('stripe::exceptions.api.invalid_request');
        } elseif ($e instanceof Error\Authentication) {
            $message = Lang::trans('stripe::exceptions.api.authentication');
        } elseif ($e instanceof Error\ApiConnection) {
            $message = Lang::trans('stripe::exceptions.api.connection');
        } elseif ($e instanceof Error\Base) {
            $message = Lang::trans('stripe::exceptions.api.general');
        }

        return Response::json(compact('message'), $errorCode);
    }
}
