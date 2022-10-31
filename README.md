# laravel-weather-apis

Need to install the following:

- [PHP](https://www.php.net/manual/en/install.macosx.packages.php)
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
- [gRPC for PHP](https://cloud.google.com/php/grpc)

Once the above are installed, got to `/weather` and run:

```bash
composer install
```

You need to the following env variables:

- `API_KEY` this is for weather API. Ask Erika for the key.
- `MOMENTO_AUTH_TOKEN`
- `MOMENTO_CACHE_NAME`

To run this application:

```bash
php artisan serve
```

Once it's running, in another Terminal window type:

```bash
curl http://127.0.0.1:8000/api/weather/<your-favorite-city>
```

or

```bash
curl http://127.0.0.1:8000/api/weather/<your-favorite-zipcode>/<country-code-such-as-us>
```

or

```bash
curl http://127.0.0.1:8000/api/weather/id/<your-favorite-city-id>

City id can be found here: http://bulk.openweathermap.org/sample/
```

Example:
curl http://127.0.0.1:8000/api/weather/98101/us

```

```
