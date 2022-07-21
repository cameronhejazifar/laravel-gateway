# Laravel Gateway 

This project is designed to act as an api-gateway for local development using PHP and Laravel.

In a microservice architecture, an api-gateway is often used as a conglomerate of each individual service to have a central access point to all of your api endpoints. This will serve as a very dumbed down version of that, and should only be used for local development  *NOTE: this solution should NOT be used as a staged or production level application.*

Let's say you have 3 microservices (accounts, settings, notes) in your parked Valet directory and each service has multiple endpoints that can be accessed by these URLs in your local environment:

- POST `http://accounts.test/create`
- GET `http://accounts.test/get-user`
- POST `http://accounts.test/password/reset`
- PATCH `http://settings.test/update`
- GET `http://notes.test/notes`
- POST `http://notes.test/notes`
- PATCH `http://notes.test/notes/{note-id}`
- DELETE `http://notes.test/notes/{note-id}`

Using this gateway, all of these routes can be accessed from an individual domain, like so:

- POST `http://laravel-gateway.test/accounts/create`
- GET `http://laravel-gateway.test/accounts/get-user`
- POST `http://laravel-gateway.test/accounts/password/reset`
- PATCH `http://laravel-gateway.test/settings/update`
- GET `http://laravel-gateway.test/notes/notes`
- POST `http://laravel-gateway.test/notes/notes`
- PATCH `http://laravel-gateway.test/notes/notes/{note-id}`
- DELETE `http://laravel-gateway.test/notes/notes/{note-id}`


## Setup

Make sure you have PHP 8.1, [Laravel 9](https://laravel.com/docs/9.x), and [Laravel Valet](https://laravel.com/docs/9.x/valet) installed on your local machine before continuing.

Clone the repo into your parked Valet directory, and then run the following commands

```shell
cd ~/my-valet-directory/laravel-gateway (make sure you use the directory you cloned this repo to)
composer install
```

You should now be able to hit this service locally by using this URL:

`http://laravel-gateway.test`

Any routes that you hit should be proxy along to any microservices you have in your parked Valet directory and the response will be returned. For example:

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
