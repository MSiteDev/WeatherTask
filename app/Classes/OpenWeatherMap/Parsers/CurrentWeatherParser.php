<?php

namespace App\Classes\OpenWeatherMap\Parsers;

use Exception;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;
use App\Classes\OpenWeatherMap\Exceptions\InvalidCurrentWeatherDataException;

/**
 * Class CurrentWeatherParser
 * @package App\Classes\OpenWeatherMap\Parsers
 *
 * Weather data...
 *
 * @property-read float temperature
 * @property-read int pressure
 * @property-read int humidity
 * @property-read float windSpeed
 * @property-read int windDeg
 * @property-read int cloudsPercent // TODO: cloudsPercent
 * @property-read int sunrise
 * @property-read int sunset
 * @property-read string icon
 *
 * Base info...
 *
 * @property-read int id
 * @property-read string cityName
 * @property-read string country_code
 * @property-read float cord_lon
 * @property-read float cord_lat
 */
class CurrentWeatherParser
{
    public const ATTRIBUTES_MAP = [
        // Weather data...
        "main.temp" => "temperature",
        "main.pressure" => "pressure",
        "main.humidity" => "humidity",
        "wind.speed" => "windSpeed",
        "wind.deg" => "windDeg",
        "sys.sunrise" => "sunrise",
        "sys.sunset" => "sunset",
        "weather.0.icon" => "icon",

        // Base info...
        "id" => "id",
        "name" => "cityName",
        "sys.country" => "country_code",
        "coord.lon" => "cord_lon",
        "coord.lat" => "cord_lat"
    ];

    /** @var bool */
    protected $isInvalid = false;

    /** @var array */
    protected $attributes = [];
    /**
     * @var array|null
     */
    private $originalResponse;


    public function __construct($response)
    {
        try
        {
            if(!$response)
                throw new InvalidCurrentWeatherDataException;

            if($response instanceof ResponseInterface)
                $response = $response->getBody();

            if($response instanceof StreamInterface)
                $response = $response->getContents();

            if(is_string($response) && $response = json_decode($response, true))
            {
                $this->originalResponse = $response;
                $this->initialize();
            }
            else
                throw new InvalidCurrentWeatherDataException;

        }
        catch (Exception $e)
        {
            $this->isInvalid = true;
        }

    }

    protected function initialize()
    {
        foreach(static::ATTRIBUTES_MAP as $externalKey => $internalKey)
            $this->setAttribute($internalKey, data_get($this->originalResponse, $externalKey));
    }

    protected function setAttribute(string $attr, $value)
    {
        $this->attributes[$attr] = $value;
        return $this;
    }

    public function isValid()
    {
        return !$this->isInvalid;
    }

    public function __get($name)
    {
        if($this->isInvalid)
            return null;

        if(isset($this->attributes[$name]))
            return $this->attributes[$name];


        return null;
    }
}
