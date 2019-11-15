<?php

namespace App\Classes\OpenWeatherMap;

use App\Classes\OpenWeatherMap\Parsers\CurrentWeatherParser;
use App\Entities\Place;
use GuzzleHttp\Client as HttpClient;

class Client
{
    /** @var Client */
    protected $httpClient;

    protected const BASE_URL = "https://api.openweathermap.org/data/2.5/";

    /**
     * @return HttpClient
     */
    protected function client()
    {
        if (!$this->httpClient)
            $this->httpClient = new HttpClient([
                'base_uri' => static::BASE_URL,
            ]);

        return $this->httpClient;
    }

    protected function createQuery(array $query): array
    {
        $query['units'] = "metric";

        if (empty($query['appid']))
            $query['appid'] = config('apis.open_weather_map.api_key');

        return $query;
    }

    public function getCurrentWeatherThroughPlaceName(string $name, string $countryCode = null)
    {
        return $this->getCurrentWeather([
            'q' => $countryCode ? "{$name},{$countryCode}" : $name
        ]);
    }

    public function getCurrentWeatherThroughOWMId(int $owmCityId)
    {
        return $this->getCurrentWeather([
            'id' => $owmCityId
        ]);
    }

    public function getCurrentWeatherThroughPlaceModel(Place $place)
    {
        return $this->getCurrentWeatherThroughOWMId($place->owm_id);
    }

    /**
     * @param array $query
     * @return CurrentWeatherParser
     */
    protected function getCurrentWeather(array $query)
    {
        try
        {
            $response = $this->client()->get("weather", [
                'query' => $this->createQuery($query)
            ]);
        }
        catch(\Exception $e)
        {
            $response = null;
        }

        return new CurrentWeatherParser($response);
    }
}
