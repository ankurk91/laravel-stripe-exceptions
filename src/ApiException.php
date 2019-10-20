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
        $exception = $this->getPrevious();

        $message = Lang::get('stripe::exceptions.api.unknown');
        $httpCode = 500;

        switch (get_class($exception)) {
            case Exception\CardException::class:
                $httpCode = 400;
                $message = data_get(
                    $exception->getJsonBody(), 'error.message',
                    Lang::get('stripe::exceptions.api.invalid_card')
                );
                break;
            case Exception\RateLimitException::class:
                $message = Lang::get('stripe::exceptions.api.rate_limit');
                break;
            case Exception\InvalidRequestException::class:
                $httpCode = 400;
                $message = Lang::get('stripe::exceptions.api.invalid_request');
                break;
            case Exception\AuthenticationException::class:
                $message = Lang::get('stripe::exceptions.api.authentication');
                break;
            case Exception\ApiConnectionException::class:
                $message = Lang::get('stripe::exceptions.api.connection');
                break;
            case Exception\ApiErrorException::class:
                $message = Lang::get('stripe::exceptions.api.general');
                break;
        }

        return Response::json(compact('message'), $httpCode);
    }
}
