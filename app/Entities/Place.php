<?php

namespace App\Entities;

use App\Support\Collections\PlaceCollection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * Class Place
 * @package App\Entities
 * @mixin \Eloquent
 *
 * @property int id
 * @property int owm_id
 * @property string name
 * @property string country_code
 * @property float cord_lon
 * @property float cord_lat
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships...
 *
 * @property-read Weather currentWeather
 *
 * Scopes...
 *
 * @method Builder|static aliasIncludes(string $query)
 * @see Place::scopeAliasIncludes()
 *
 */
class Place extends Model
{
    // Configuration...

    public function newCollection(array $models = [])
    {
        return new PlaceCollection($models);
    }

    // Relationships...

    public function currentWeather()
    {
        return $this->hasOne(Weather::class, 'place_id')->latest('status_at');
    }

    // scopes...

    public function scopeAliasIncludes(Builder $builder, string $query)
    {
        $builder->whereIn('id', function (QueryBuilder $builder) use ($query) {
            $builder->select('place_id')
                ->from((new PlaceAlias)->getTable())
                ->where('name', 'like', "%{$query}%");
        });
    }
}
