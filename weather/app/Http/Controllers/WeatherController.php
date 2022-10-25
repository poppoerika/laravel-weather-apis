<?php

namespace App\Http\Controllers;

use App\Extensions\MomentoStore;
use GuzzleHttp\Client;
use Momento\Auth\EnvMomentoTokenProvider;
use Momento\Cache\SimpleCacheClient;

class WeatherController extends Controller
{

    protected MomentoStore $momentoStore;
    protected Client $httpClient;

    public function __construct()
    {
        $cacheName = "laravel-momento";
        $authProvider = new EnvMomentoTokenProvider("MOMENTO_AUTH_TOKEN");
        $momentoSimpleCacheClient = new SimpleCacheClient($authProvider, 60);
        $momentoStore = new MomentoStore($momentoSimpleCacheClient, $cacheName);
        $this->momentoStore = $momentoStore;

        $httpClient = new Client();
        $this->httpClient = $httpClient;
    }

    public function city($city)
    {
        $apiKey = config("weatherapi.api_key");
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}";
        $cityWeatherInfo = "city_weather_info";
        $result = $this->momentoStore->get($cityWeatherInfo);
        if ($result->asHit()) {
            return $result->asHit()->value();
        } elseif ($result->asMiss()) {
            $res = $this->httpClient->get($url);
            if ($res->getStatusCode() == 200) {
                $json = $res->getBody();
                // 10 minutes TTL
                $this->momentoStore->put($cityWeatherInfo, json_decode($json), 600);
                return $res;
            }
        } elseif ($result->asError()) {
            return $result->asError()->message();
        }
        return $result;
    }

    public function zipcode($zipcode, $countryCode)
    {
        $apiKey = config("weatherapi.api_key");
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$zipcode},{$countryCode}&appid={$apiKey}";
        $zipcodeWeatherInfo = "zipcode_weather_info";
        $result = $this->momentoStore->get($zipcodeWeatherInfo);
        if ($result->asHit()) {
            return $result->asHit()->value();
        } elseif ($result->asMiss()) {
            $res = $this->httpClient->get($url);
            if ($res->getStatusCode() == 200) {
                $json = $res->getBody();
                // 10 minutes TTL
                $this->momentoStore->put($zipcodeWeatherInfo, json_decode($json), 600);
                return $res;
            }
        } elseif ($result->asError()) {
            return $result->asError()->message();
        }
        return $result;
    }
}
