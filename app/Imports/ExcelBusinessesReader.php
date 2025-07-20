<?php

namespace App\Imports;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ExcelBusinessesReader implements OnEachRow, WithHeadingRow
{
    public Collection $businesses;

    public function __construct()
    {
        $this->businesses = collect();
    }

    public function onRow(Row $row)
    {
        $data = $row->toArray();

        // تحقق من أن الصف يحتوي على اسم على الأقل
        if (!empty($data['name'])) {
            $this->businesses->push($data);
        }
    }

    public function getBusinesses(): Collection
    {
        return $this->businesses;
    }
}
