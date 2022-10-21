<?php

namespace App\Http\Controllers;

use DateInterval;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function city($city)
    {
        $api_key = config("weatherapi.api_key");
        $client = new Client();
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$api_key}";
        $cityWeatherInfo = "city_weather_info";
        $result = Cache::get($cityWeatherInfo);
        if (is_null($result)) {
            $res = $client->get($url);
            if ($res->getStatusCode() == 200) {
                $json = $res->getBody();
                // 10 minutes TTL
                Cache::put($cityWeatherInfo, json_decode($json), new DateInterval( "PT10M" ));
                return $res;
            }
        }
        return $result;
    }

    public function zipcode($zipcode, $countryCode)
    {
        $api_key = config("weatherapi.api_key");
        $client = new Client();
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$zipcode},{$countryCode}&appid={$api_key}";
        $cityWeatherInfo = "city_weather_info";
        $result = Cache::get($cityWeatherInfo);
        if (is_null($result)) {
            $res = $client->get($url);
            if ($res->getStatusCode() == 200) {
                $json = $res->getBody();
                // 10 minutes TTL
                Cache::put($cityWeatherInfo, json_decode($json), new DateInterval( "PT10M" ));
                return $res;
            }
        }
        return $result;
    }
}
