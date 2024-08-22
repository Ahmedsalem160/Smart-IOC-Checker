<?php 
namespace App\Exports;

use App\Models\Indicator;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IOCsExport implements FromCollection, WithHeadings
{
    protected $malwareFamilyId;

    public function __construct($malwareFamilyId)
    {
        $this->malwareFamilyId = $malwareFamilyId;
    }
    public function collection()
    {   // will return the data from the indicator model that related with DB 
        return Indicator::where('malwarefamilies_id', $this->malwareFamilyId)
        ->get(['type', 'value', 'source', 'created_at']);
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
