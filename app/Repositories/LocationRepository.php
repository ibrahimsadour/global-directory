<?php

namespace App\Repositories;

use App\Models\Location;

class LocationRepository
{
    public function getAllLocations()
    {
        return Location::orderBy('area', 'asc')->get();
    }
}
