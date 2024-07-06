# Changelog

## [3.14.0](https://github.com/ankurk91/laravel-stripe-exceptions/compare/3.13.0...3.14.0)

* Allow stripe-php sdk v14 and v15
* Remove stripe-php sdk v8 and v9

## [3.13.0](https://github.com/ankurk91/laravel-stripe-exceptions/compare/3.12.0...3.13.0)

* Allow Laravel v11
* Drop support for php 8.1
* Drop support for Laravel v9

## [3.9.0](https://github.com/ankurk91/laravel-stripe-exceptions/compare/3.8.0...3.9.0)

* Bring back support for stripe-php v8.0

## [3.7.0](https://github.com/ankurk91/laravel-stripe-exceptions/compare/3.6.0...3.7.0)

* Test on php v8.2
* Remove support for stripe-php v8.0
* Add support for stripe-php v10.0

## [3.6.0](https://github.com/ankurk91/laravel-stripe-exceptions/compare/3.5.0...3.6.0)

* Remove support for stripe-php v7.0
* Add support for stripe-php v9.0

## [3.5.0](https://github.com/ankurk91/laravel-stripe-exceptions/compare/3.4.1...3.5.0)

* Drop support for Laravel v8.x

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
