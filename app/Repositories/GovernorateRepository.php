<?php

namespace App\Repositories;

use App\Models\Governorate;

class GovernorateRepository
{
    protected $model;

    public function __construct(Governorate $model)
    {
        $this->model = $model;
    }

public function getAllGovernorates()
{
    return $this->model
        ->with(['locations' => function ($query) {
            $query->where('is_active', 1)->orderBy('area', 'asc');
        }])
        ->where('is_active', 1)
        ->orderBy('name', 'asc')
        ->get();
}

}
