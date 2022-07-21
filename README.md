# Setup

Make sure you have PHP 8.1, [Laravel 9](https://laravel.com/docs/9.x), and [Laravel Valet](https://laravel.com/docs/9.x/valet) installed on your local machine before continuing.

Clone the repo into your parked Valet directory, and then run the following commands

```shell
cd ~/my-valet-directory/laravel-gateway (make sure you use the directory you cloned this repo to)
composer install
```

You should now be able to hit this service locally by using this URL:

`http://laravel-gateway.test`

Any routes that you hit should be proxied along to any microservices you have in your parked Valet directory and the response will be returned. For example:

`http://laravel-gateway.test/accounts` would route to `http://accounts.test`

`http://laravel-gateway.test/accounts/api/auth` would route to: `http://accounts.test/api/auth`

This service supports proxying for the following request methods:

- `GET`
- `POST`
- `PUT`
- `PATCH`
- `DELETE`
- `OPTIONS`

This service supports forwarding request headers, the content body, and query parameters.
