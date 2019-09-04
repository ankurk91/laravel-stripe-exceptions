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
        $e = $this->getPrevious();
        $message = Lang::get('stripe::exceptions.oauth.unknown');

        if ($e instanceof Exception\OAuth\InvalidClientException) {
            $message = Lang::get('stripe::exceptions.oauth.invalid_client');
        } elseif ($e instanceof Exception\OAuth\InvalidRequestException) {
            $message = Lang::get('stripe::exceptions.oauth.invalid_request');
        } elseif ($e instanceof Exception\OAuth\OAuthErrorException) {
            $message = Lang::get('stripe::exceptions.oauth.general');
        }

        return Response::redirectTo($this->redirectTo)->with('error', $message);
    }
}
