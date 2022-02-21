<?php
declare(strict_types=1);

namespace Ankurk91\StripeExceptions;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Response;
use Stripe\Exception;

class ApiException extends AbstractException
{
    protected array $dontReport = [
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

        $response['message'] = Lang::get('stripe::exceptions.api.unknown');
        $response['stripe'] = [];
        $httpCode = 500;

        if ($exception instanceof Exception\ApiErrorException) {
            $response['stripe']['code'] = $exception->getStripeCode();
        }

        switch (get_class($exception)) {
            case Exception\CardException::class:
                $httpCode = 400;
                $response['message'] = data_get(
                    $exception->getJsonBody(), 'error.message',
                    Lang::get('stripe::exceptions.api.invalid_card')
                );
                $response['stripe']['declined_code'] = $exception->getDeclineCode();
                $response['stripe']['param'] = $exception->getStripeParam();
                break;

            case Exception\RateLimitException::class:
                $response['message'] = Lang::get('stripe::exceptions.api.rate_limit');
                break;

            case Exception\InvalidRequestException::class:
                $httpCode = 400;
                $response['message'] = Lang::get('stripe::exceptions.api.invalid_request');
                $response['stripe']['param'] = $exception->getStripeParam();
                break;

            case Exception\AuthenticationException::class:
                $response['message'] = Lang::get('stripe::exceptions.api.authentication');
                break;

            case Exception\ApiConnectionException::class:
                $response['message'] = Lang::get('stripe::exceptions.api.connection');
                break;

            case Exception\ApiErrorException::class:
                $response['message'] = Lang::get('stripe::exceptions.api.general');
                break;
        }

        return Response::json($response, $httpCode);
    }
}
