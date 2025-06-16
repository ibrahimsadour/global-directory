<?php

namespace App\Imports;

use App\Jobs\ImportBusinessRowJob;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BusinessesImport implements ToModel, WithHeadingRow
{
    protected $admin;

    public function __construct($admin)
    {
        $this->admin = $admin;
    }

    public function model(array $row)
    {
        // إرسال كل صف إلى Job
        ImportBusinessRowJob::dispatch($row, $this->admin);

        return null;
    }
}
