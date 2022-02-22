# Changelog

## [3.4.0](https://github.com/ankurk91/laravel-stripe-exceptions/compare/3.3.0...3.4.0)

* Add more information to error response, like `declined_code` for credit card exception etc.

## [3.3.0](https://github.com/ankurk91/laravel-stripe-exceptions/compare/3.2.0...3.3.0)

* Allow Laravel v9.x
* Drop support for php 7.4

## [3.2.0](https://github.com/ankurk91/laravel-stripe-exceptions/compare/3.1.0...3.2.0)

* Let Laravel handle the reporting and logging of exceptions

## [3.1.0](https://github.com/ankurk91/laravel-stripe-exceptions/compare/3.0.0...3.1.0)

* Drop support for Laravel 7.x
* Drop support for php v7.3
* Test on php v8.1

## [3.0.0](https://github.com/ankurk91/laravel-stripe-exceptions/compare/2.0.0...3.0.0)

* Upgrade to use `stripe-php@7.0`
* Support Laravel v6.0

## [2.0.0](https://github.com/ankurk91/laravel-stripe-exceptions/compare/1.1.0...2.0.0)

* Changed:
    - `PaymentException` class has been renamed to `ApiException`
    - Translation key `stripe::exceptions.payment` has been renamed to `stripe::exceptions.api`
