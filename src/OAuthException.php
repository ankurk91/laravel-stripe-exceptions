<?php

namespace LaravelExceptions\Stripe;

use Stripe\Error;
use Throwable;

class OAuthException extends Base
{
    /**
     * @var string
     */
    protected $redirectTo;

    /**
     * A list of the exception types that not be reported.
     *
     * @var array
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
        $message = 'Unable to authorize with Stripe.';

        return redirect()->to($this->redirectTo)->with('error', $message);
    }
}
