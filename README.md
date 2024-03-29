# Stripe Exceptions for Laravel

[![Packagist](https://badgen.net/packagist/v/ankurk91/laravel-stripe-exceptions)](https://packagist.org/packages/ankurk91/laravel-stripe-exceptions)
[![GitHub tag](https://badgen.net/github/tag/ankurk91/laravel-stripe-exceptions)](https://github.com/ankurk91/laravel-stripe-exceptions/tags)
[![License](https://badgen.net/packagist/license/ankurk91/laravel-stripe-exceptions)](LICENSE.txt)
[![Downloads](https://img.shields.io/packagist/dt/ankurk91/laravel-stripe-exceptions)](https://packagist.org/packages/ankurk91/laravel-stripe-exceptions/stats)
[![tests](https://github.com/ankurk91/laravel-stripe-exceptions/workflows/tests/badge.svg)](https://github.com/ankurk91/laravel-stripe-exceptions/actions)
[![codecov](https://codecov.io/gh/ankurk91/laravel-stripe-exceptions/branch/main/graph/badge.svg)](https://codecov.io/gh/ankurk91/laravel-stripe-exceptions)

This package makes it easy to handle [Stripe](https://github.com/stripe/stripe-php) exceptions in Laravel

How do you handle Stripe errors? 
Are you repeating [same code](https://stripe.com/docs/api/errors/handling?lang=php) again and again?

## Installation

You can install the package via composer:

```bash
composer require ankurk91/laravel-stripe-exceptions
```

## Usage

Handle Stripe charge/transfer exceptions by wrapping the API calls in try/catch like:

```php
<?php

try {
    $response = \Stripe\Charge::create([
        'source' => request('source'),
        'amount' => 1000,
        'currency' => 'usd',
    ]);
} catch (\Throwable $exception) {
    // send back an errored JSON response to browser
    throw new \Ankurk91\StripeExceptions\ApiException($exception);
}
```

Handle Stripe connect exceptions:

```php
<?php

try {
    $response = \Stripe\OAuth::token([
        'grant_type' => 'authorization_code',
        'code' => request('code')
    ]);
} catch (\Throwable $exception) {
    // redirect with failed error message
    // `error` will be flashed in session to destination page
    throw new \Ankurk91\StripeExceptions\OAuthException($exception, route('stripe.failed'));
}
```

## Modifying error messages

You can publish the translation messages via this command

```bash
php artisan vendor:publish --provider="Ankurk91\StripeExceptions\StripeServiceProvider" --tag=translations
```

## Features

* Takes advantage of Laravel's
  inbuilt [Reportable & Renderable Exceptions](https://laravel.com/docs/10.x/errors#renderable-exceptions).
* Reports all exceptions when `APP_DEBUG` is `true`
* Prevents logging of exceptions caused by user input, for example `Invalid Card`
* Captures logged-in user information when an exception gets reported

## Security

If you discover any security issues, please email `pro.ankurk1[at]gmail[dot]com` instead of using the issue tracker.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## License

The [MIT](https://opensource.org/licenses/MIT) License.
