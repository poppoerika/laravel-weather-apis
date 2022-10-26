<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    protected Client $httpClient;

    public function __construct()
    {
        $httpClient = new Client();
        $this->httpClient = $httpClient;
    }

    public function city($city)
    {
        $apiKey = config("weatherapi.api_key");
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}";
        $cityWeatherInfo = "city_weather_info";
        $result = Cache::get($cityWeatherInfo);
        if (!is_null($result)) {
            return json_decode($result->asHit()->value());
        } else {
            $res = $this->httpClient->get($url);
            if ($res->getStatusCode() == 200) {
                $json = $res->getBody();
                // 10 minutes TTLc
                Cache::put($cityWeatherInfo, $json, 600);
                return json_decode($json);
            }
        }
    }

    public function zipcode($zipcode, $countryCode)
    {
        $apiKey = config("weatherapi.api_key");
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$zipcode},{$countryCode}&appid={$apiKey}";
        $zipcodeWeatherInfo = "zipcode_weather_info";
        $result = Cache::get($zipcodeWeatherInfo);
        if (!is_null($result)) {
            return json_decode($result->asHit()->value());
        } else {
            $res = $this->httpClient->get($url);
            if ($res->getStatusCode() == 200) {
                $json = $res->getBody();
                // 10 minutes TTLc
                Cache::put($zipcodeWeatherInfo, $json, 600);
                return json_decode($json);
            }
        }
    }
}
