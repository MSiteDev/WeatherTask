<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Weather
 * @package App\Entities
 * @mixin \Eloquent
 *
 * @property int id
 * @property int place_id
 * @property string icon
 * @property Carbon sunset_at
 * @property Carbon sunrise_at
 * @property int temperature
 * @property int humidity
 * @property int pressure
 * @property int wind_speed
 * @property int wind_degree
 * @property int clouds_percent
 * @property Carbon status_at
 */
class Weather extends Model
{
    public $timestamps = false;
    protected $casts = [
        'sunset_at' => "datetime",
        'sunrise_at' => "datetime",
        'status_at' => "datetime"
    ];
}
