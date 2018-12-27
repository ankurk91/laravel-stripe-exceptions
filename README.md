# Stripe Exceptions for Laravel

[![Packagist](https://img.shields.io/packagist/v/ankurk91/laravel-stripe-exceptions.svg)](https://packagist.org/packages/ankurk91/laravel-stripe-exceptions)
[![GitHub tag](https://img.shields.io/github/tag/ankurk91/laravel-stripe-exceptions.svg)](https://github.com/ankurk91/laravel-stripe-exceptions/releases)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.txt)
[![Downloads](https://img.shields.io/packagist/dt/ankurk91/laravel-stripe-exceptions.svg)](https://packagist.org/packages/ankurk91/laravel-stripe-exceptions/stats)
[![StyleCI](https://styleci.io/repos/144573966/shield?branch=master&style=plastic)](https://styleci.io/repos/144573966)

This package makes it easy to handle [Stripe](https://github.com/stripe/stripe-php) exceptions in Laravel v5.7

## Installation
You can install the package via composer:
```
composer require ankurk91/laravel-stripe-exceptions
```

## Usage
Handle payment exceptions
```php
    try {
        $response = \Stripe\Charge::create([
            'source' => request('source'),
            'amount' => 1000,
            'currency' => 'usd',
        ]);
    } catch (\Throwable $exception) {
        throw new PaymentException($exception);
    }
```
Handle stripe connect exceptions
```php
    try {
        $response = \Stripe\OAuth::token([
            'grant_type' => 'authorization_code',
            'code' => request('code')
        ]);
    } catch (\Throwable $exception) {
        throw new OAuthException($exception, route('stripe.status'));
    }
```

## Security
If you discover any security related issues, please email `pro.ankurk1[at]gmail[dot]com` instead of using the issue tracker.

## License
The [MIT](https://opensource.org/licenses/MIT) License.
