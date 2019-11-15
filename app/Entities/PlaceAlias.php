<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlaceAlias
 * @package App\Entities
 * @mixin \Eloquent
 *
 * @property int id
 * @property int place_id
 * @property string name
 * @property Carbon created_at
 */
class PlaceAlias extends Model
{
    public const UPDATED_AT = null;

    // Relationships...

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }
}
