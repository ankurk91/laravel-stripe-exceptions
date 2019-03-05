<?php

namespace Ankurk91\StripeExceptions;

use Throwable;
use Stripe\Error;
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
        Error\OAuth\InvalidGrant::class,
        Error\OAuth\InvalidScope::class,
        Error\OAuth\UnsupportedResponseType::class,
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
        $message = Lang::trans('stripe::exceptions.oauth.unknown');

        if ($e instanceof Error\OAuth\InvalidClient) {
            $message = Lang::trans('stripe::exceptions.oauth.invalid_client');
        } elseif ($e instanceof Error\OAuth\InvalidRequest) {
            $message = Lang::trans('stripe::exceptions.oauth.invalid_request');
        } elseif ($e instanceof Error\OAuth\OAuthBase) {
            $message = Lang::trans('stripe::exceptions.oauth.general');
        }

        return Response::redirectTo($this->redirectTo)
            ->with('error', $message);
    }
}
