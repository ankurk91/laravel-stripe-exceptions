<?php

namespace Ankurk91\StripeExceptions;

use Throwable;
use Stripe\Exception;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Lang;

class OAuthException extends AbstractException
{
    /**
     * Where to redirect when an exception occurred.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * {@inheritdoc}
     */
    protected $dontReport = [
        Exception\OAuth\InvalidGrantException::class,
        Exception\OAuth\InvalidScopeException::class,
        Exception\OAuth\UnsupportedResponseTypeException::class,
    ];

    public function __construct(Throwable $exception, string $redirectTo)
    {
        $this->redirectTo = $redirectTo;

        parent::__construct($exception);
    }

    /**
     * {@inheritdoc}
     */
    public function render($request)
    {
        switch (get_class($this->getPrevious())) {
            case Exception\OAuth\InvalidClientException::class:
                $message = Lang::get('stripe::exceptions.oauth.invalid_client');
                break;
            case Exception\OAuth\InvalidRequestException::class:
                $message = Lang::get('stripe::exceptions.oauth.invalid_request');
                break;
            case Exception\OAuth\OAuthErrorException::class:
                $message = Lang::get('stripe::exceptions.oauth.general');
                break;
            default:
                $message = Lang::get('stripe::exceptions.oauth.unknown');
        }

        return Response::redirectTo($this->redirectTo)->with('error', $message);
    }
}
