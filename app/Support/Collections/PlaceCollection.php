<?php

namespace App\Support\Collections;

use App\Entities\Place;
use Illuminate\Database\Eloquent\Collection;

class PlaceCollection extends Collection
{
    /** @var Place[] */
    protected $items = [];
}
