<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Services\OtxService;
use App\Services\ThreatfoxService;
use Illuminate\Http\Request;
use App\Models\Malwarefamily;
use App\Models\Indicator;

class OtxController extends Controller
{
    protected $otxService;
    protected $threatfoxService;

    public function __construct(OtxService $otxService, ThreatfoxService $threatfoxService)
    {
        $this->otxService = $otxService;
        $this->threatfoxService = $threatfoxService;
    }
    public function showSearchForm()
    {
        return view('search');
    }

    public function handleSearch(Request $request)
    {   $source = "AlienVault";
        $query = $request->input('query');
        //calling Alien Vault service
        // $pulses = $this->otxService->searchPulses($query);
        // Calling ThreatFox service
        $res_fox= $this->threatfoxService->search($query);
        // dd($res_fox);
        $extract_iocs=[];
        foreach($res_fox as $item){
            $extract_iocs[] = [
                'ioc' => $item['ioc'],
                'ioc_type' => $item['ioc_type']
            ];
        }
        $malware_id = $this->save_ioc_fox($query,$extract_iocs);
        dd($malware_id);
        ////////////////////////////////////////////////////EnD ThreatFOX Integration
        if (isset($pulses['error']) && $pulses['error']) {
            return redirect()->back()->with('error', $pulses['message']);
        }

        if (empty($pulses['results'])) {
            return redirect()->back()->with('error', 'No pulses found for the search query.');
        }
            //return response()->json(['res'=>$pulses['results']]);/////////////
        $iocResults = [];
        foreach ($pulses['results'] as $pulse) {
            $pulseDetails = $this->otxService->getPulseDetails($pulse['id']);

            if (isset($pulseDetails['error']) && $pulseDetails['error']) {
                continue; // Skip if there's an error
            }
            
            $categorizedIOCs = $this->categorizeIOCs($pulseDetails['indicators']);

            // merge the data after present it 
            $iocResults = array_merge_recursive($iocResults, $categorizedIOCs);
        }
        // store the result in DB
        $mal_id = $this->store_Malware_Indicators($query, $categorizedIOCs,$source);
        // dd($pulses['results']);
        //  dd($pulseDetails['indicators']);
        return view('search-result', compact('iocResults', 'query', 'source','mal_id'));
    }

    /**
     * Categorize IOCs into IPv4, IPv6, URLs, domains, and file hashes.
     *
     * @param array $indicators
     * @return array
     */
    private function categorizeIOCs(array $indicators)
    {
        $categorized = [
            'ipv4' => [],
            'ipv6' => [],
            'urls' => [],
            'domains' => [],
            'file_hashes' => [],
            'email' => [],
            'cve' => [],
            'hostname' => [],
            'mutex' => [],
            'uri' => [],
            'user_agent' => [],
            'md5' => [],
            'sha1' => [],
            'sha256' => [],
        ];
    
        foreach ($indicators as $indicator) {
            $value = $indicator['indicator'];
    
            switch ($indicator['type']) {
                case 'IPv4':
                    $categorized['ipv4'][] = $value;
                    break;
                case 'IPv6':
                    $categorized['ipv6'][] = $value;
                    break;
                case 'URL':
                    $categorized['urls'][] = $value;
                    break;
                case 'domain':
                    $categorized['domains'][] = $value;
                    break;
                case 'email':
                    $categorized['email'][] = $value;
                    break;
                case 'CVE':
                    $categorized['cve'][] = $value;
                    break;
                case 'hostname':
                    $categorized['hostname'][] = $value;
                    break;
                case 'mutex':
                    $categorized['mutex'][] = $value;
                    break;
                case 'URI':
                    $categorized['uri'][] = $value;
                    break;
                case 'UserAgent':
                    $categorized['user_agent'][] = $value;
                    break;
                case 'FileHash-MD5':
                    $categorized['md5'][] = $value;
                    break;
                case 'FileHash-SHA1':
                    $categorized['sha1'][] = $value;
                    break;
                case 'FileHash-SHA256':
                    $categorized['sha256'][] = $value;
                    break;
                default:
                    $categorized['others'][] = $value;
                    break;
            }
        }
    
        return $categorized;
    }
    

// private function paginateIndicators(array $indicators, $perPage = 10)
// {
//     $page = request()->get('page', 1); // Get the current page or default to 1
//     $total = count($indicators); // Total indicators count

//     $startingPoint = ($page - 1) * $perPage;
//     $indicators = array_slice($indicators, $startingPoint, $perPage);

//     return new LengthAwarePaginator($indicators, $total, $perPage, $page, [
//         'path' => request()->url(),
//         'query' => request()->query(),
//     ]);
// }

//storing the iocs in DB   From AlienVault
private function store_Malware_Indicators($familyName, $indicators)
{
    // Find or create the malware family
    $malwareFamily = Malwarefamily::firstOrCreate(
        ['name' => $familyName],
        ['description' => 'Description of ' . $familyName], // Adjust this as needed
        ['source'=>"AlienVault"]
    );

    // Categorize and store each IOC
    foreach ($indicators as $type=>$iocs) {
        foreach ($iocs as $ioc) {
            $malwareFamily->indicators()->create([
                'type' => $type,
                'value' => $ioc,
                'source' => "AlienVault",
                // 'malwarefamily_id' => $malwareFamily->id,
            ]);
        }
    }
    return $malwareFamily->id;
}
//storing the iocs in DB From Threatfox
private function save_ioc_fox($malwareFamily,$iocs){
        // Find or create the malware family
        $malwareFamily = Malwarefamily::firstOrCreate(
            ['name' => $malwareFamily],
            ['description' => 'Description of ' . $malwareFamily], // Adjust this as needed
            ['source'=> "Threat Fox"]
        );
    
        // Categorize and store each IOC
        
        foreach ($iocs as $ioc) {
            $malwareFamily->indicators()->create([
                'type' => $ioc["ioc_type"],
                'value' => $ioc["ioc"],
                'source' => "Threat Fox",
                // 'malwarefamily_id' => $malwareFamily->id,
            ]);
        }
        
        return $malwareFamily->id;
}
////////////////////////////////////////////////
private function categorizeIOCs2($indicators)
{
    $categorizedIOCs = [];

    foreach ($indicators as $ioc) {
        $type = $this->getIOCTypes($ioc['type']);

        // Initialize the array for this type if it doesn't exist
        if (!isset($categorizedIOCs[$type])) {
            $categorizedIOCs[$type] = [];
        }

        // Add the IOC data to the corresponding type array
        $categorizedIOCs[$type][] = [
            'value' => $ioc['indicator'],
            'source' => $ioc['description'] ?? 'Unknown',
            'created_at' => $ioc['created'] ?? now(), // Example of another related data field
            // Add more fields as needed
        ];
    }

    return $categorizedIOCs;
}

private function getIOCTypes($type)
{
    $typesMap = [
        'IPv4' => 'ipv4',
        'IPv6' => 'ipv6',
        'domain' => 'domain',
        'url' => 'url',
        'hostname' => 'hostname',
        'md5' => 'file_hashes',
        'sha1' => 'file_hashes',
        'sha256' => 'file_hashes',
    ];

    return $typesMap[$type] ?? 'other';
}

}
