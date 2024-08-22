<?php

namespace App\Http\Controllers;

use App\Exports\IOCsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class ExportController extends Controller
{
    public function export($mal_id)
    {
        return Excel::download(new IOCsExport($mal_id), now()->format('Y-m-d_H-i-s').'iocs.xlsx');
    }
}
