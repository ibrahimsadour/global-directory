<?php

namespace App\Imports;

use App\Models\Governorate;
use Maatwebsite\Excel\Concerns\ToModel;

class GovernoratesImport implements ToModel
{
    public function model(array $row)
    {
        // تخطي السطر الأول (رأس الجدول)
        if ($row[0] == 'name' || $row[0] == null) {
            return null;
        }

        return new Governorate([
            'name'        => $row[0],
            'slug'        => $row[1],
            'image'       => $row[2] ?? null,
            'description' => $row[3] ?? null,
            'latitude'    => $row[4] ?? null,
            'longitude'   => $row[5] ?? null,
            'is_active'   => $row[6] ?? 1,
        ]);
    }
}
