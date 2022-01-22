<?php
declare(strict_types=1);

namespace Ankurk91\StripeExceptions;

use Throwable;
use Stripe\Exception;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Lang;

class OAuthException extends AbstractException
{
    /**
     * Where to redirect when an exception occurred.
     */
    protected string $redirectTo;

    protected array $dontReport = [
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
        $message = match (get_class($this->getPrevious())) {
            Exception\OAuth\InvalidClientException::class => Lang::get('stripe::exceptions.oauth.invalid_client'),
            Exception\OAuth\InvalidRequestException::class => Lang::get('stripe::exceptions.oauth.invalid_request'),
            Exception\OAuth\OAuthErrorException::class => Lang::get('stripe::exceptions.oauth.general'),
            default => Lang::get('stripe::exceptions.oauth.unknown'),
        };

        return Response::redirectTo($this->redirectTo)->with('error', $message);
    }
}
