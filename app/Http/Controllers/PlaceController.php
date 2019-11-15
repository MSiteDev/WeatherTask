<?php

namespace App\Http\Controllers;

use App\Classes\OpenWeatherMap\Client;
use App\Entities\Place;
use App\Entities\PlaceAlias;
use App\Entities\Weather;
use App\Http\Resources\PlaceList;
use App\Http\Resources\SimplePlace;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index()
    {
        return PlaceList::collection((new Place)->latest('update_at')->paginate(10));
    }

    public function search(Request $request)
    {
        $q = $request->get('q');

        $places = $q ? (new Place)->aliasIncludes($q)->get() : (new Place)->newCollection();

        $places->load('currentWeather');

        return PlaceList::collection($places);
    }

    public function show(Place $place, Client $weatherClient)
    {
        if ((!$place->updated_at || !$place->updated_at->isCurrentHour()) && $response = $weatherClient->getCurrentWeatherThroughPlaceModel($place))
        {

            $place->currentWeather()->create([
                'icon' => $response->icon,
                'sunset_at' => Carbon::createFromTimestampUTC($response->sunset),
                'sunrise_at' => Carbon::createFromTimestampUTC($response->sunrise),
                'temperature' => $response->temperature,
                'humidity' => $response->humidity,
                'pressure' => $response->pressure,
                'wind_speed' => $response->windSpeed,
                'wind_degree' => $response->windDeg,
                'clouds_percent' => $response->cloudsPercent
            ]);
            $place->touch();
        }

        return new SimplePlace($place->loadMissing('currentWeather'));
    }

    public function create(Request $request, Client $weatherClient)
    {
        $q = $request->get('q');

        if (!$q)
            abort(400);

        $alias = PlaceAlias::where('name', $q)->first();

        if (!$alias)
        {
            $alias = new PlaceAlias(['name' => $q]);

            if(($response = $weatherClient->getCurrentWeatherThroughPlaceName($q))->isValid())
            {
                $place = Place::firstOrNew(['owm_id' => $response->id]);

                if(!$place->exists)
                {
                    $place->fill([
                        'name' => $response->cityName,
                        'country_code' => $response->country_code,
                        'cord_lat' => $response->cord_lat,
                        'cord_lon' => $response->cord_lon,
                        'updated_at' => null
                    ])->save();
                }

                $alias->place()->associate($place);
            }

            $alias->save();
        }

        return ($alias && $alias->place) ? $this->show($alias->place, $weatherClient) : abort(404);
    }
}
