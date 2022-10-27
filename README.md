# laravel-weather-apis

Need to install the following:
- [PHP](https://www.php.net/manual/en/install.macosx.packages.php) 
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
Once Composer is installed, you can install `laravel/installer` using composer. [reference](https://www.javatpoint.com/how-to-install-laravel-on-mac)
- [gRPC for PHP](https://cloud.google.com/php/grpc)

Once the above are installed run:
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
curl http://127.0.0.1:8000/api/weather/<your-favorite-zipcode>,<country-code-such-as-us>


Example:
curl http://127.0.0.1:8000/api/weather/98101,us
```
