<?php

namespace App\Imports;

use App\Models\Location;
use App\Models\Governorate;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LocationsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $governorate = Governorate::where('name', $row['governorate_name'])->first();

        if (!$governorate) {
            // نتخطى الصف لو لم نجد المحافظة
            return null;
        }

        return new Location([
            'area'          => $row['area'],
            'slug'          => Str::slug($row['area']),
            'description'   => $row['description'] ?? null,
            'latitude'      => $row['latitude'] ?? null,
            'longitude'     => $row['longitude'] ?? null,
            'polygon'     => $row['polygon'] ?? null,
            'governorate_id'=> $governorate->id,
            'is_active'     => true,
        ]);
    }
}
