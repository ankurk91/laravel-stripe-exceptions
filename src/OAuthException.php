<?php

namespace Ankurk91\StripeExceptions;

use Throwable;
use Stripe\Error;
use Illuminate\Support\Facades\Response;

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

    public function __construct(Throwable $exception, $redirectTo)
    {
        $this->redirectTo = $redirectTo;

        parent::__construct($exception);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return Response::redirectTo($this->redirectTo)
            ->with('error', 'Unable to authorize with Stripe.');
    }
}
