<?php 
namespace App\Exports;

use App\Models\Indicator;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IOCsExport implements FromCollection, WithHeadings
{
    public function collection()
    {   // will return the data from the indicator model that related with DB 
        return Indicator::all(['type', 'value', 'source', 'created_at']);
    }

    public function headings(): array
    {
        return [
            'Type',
            'Value',
            'Source',
            'Created At',
        ];
    }
}
