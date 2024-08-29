<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class IocImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        return $rows->flatten();
    }
}
