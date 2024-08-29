<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\IocImport;

class ReputationController extends Controller
{
    public function index(){
        return view('reputation-check');
    }
    public function checkIocReputation(Request $request)
    {
        // Validate input
        $request->validate([
            'single_ioc' => 'nullable|string',
            'ioc_file' => 'nullable|file|mimes:txt,xls,xlsx,csv',
        ]);

        if (!$request->has('single_ioc') && !$request->hasFile('ioc_file')) {
            return redirect()->back()->with('error', 'Please provide an IP, URL, domain, or upload a file.');
        }

        $iocs = [];

        // Handle file upload
        if ($request->hasFile('ioc_file')) {
            $file = $request->file('ioc_file');
            $extension = $file->getClientOriginalExtension();

            // Check for supported file extensions
            if (!in_array($extension, ['txt', 'xls', 'xlsx', 'csv'])) {
                return redirect()->back()->with('error', 'Unsupported file type. Please upload a .txt, .xls, .xlsx, or .csv file.');
            }

            if ($extension === 'txt') {
                $iocs = file($file->getRealPath(), FILE_IGNORE_NEW_LINES);
            } else {
                $iocs = Excel::toArray(new IocImport, $file)[0];
                $iocs = array_map('reset', $iocs); // Flatten array in case of multiple columns
            }
        } elseif ($request->has('single_ioc')) {
            // Handle single IOC input
            $iocs[] = $request->input('single_ioc');
        }

        $results = [];

        foreach ($iocs as $ioc) {
            $type = $this->determineIocType($ioc);

            // Determine the appropriate VirusTotal API endpoint based on the IOC type
            if ($type === 'IP') {
                $url = "https://www.virustotal.com/api/v3/ip_addresses/{$ioc}";
            } elseif ($type === 'Domain') {
                $url = "https://www.virustotal.com/api/v3/domains/{$ioc}";
            } elseif ($type === 'URL') {
                $url = "https://www.virustotal.com/api/v3/urls/{$this->encodeUrl($ioc)}";
            } elseif (in_array($type, ['MD5', 'SHA1', 'SHA256'])) {
                $url = "https://www.virustotal.com/api/v3/files/{$ioc}";
            } else {
                $url = "https://www.virustotal.com/api/v3/search?query=" . urlencode($ioc);
            }

            // Make the API request
            $response = Http::withHeaders([
                'x-apikey' => env('VIRUSTOTAL_KEY'),
            ])->get($url);
            $data = $response->json();

            dd($data);
            if ($response->successful()) {
                $data = $response->json();
                $results[$ioc] = [
                    'type' => $type,
                    'data' => $data,
                ];
            } else {
                $results[$ioc] = [
                    'type' => $type,
                    'error' => $response->json()['error'] ?? 'Unknown error',
                ];
            }
        }

        return view('reputation-result', compact('results'));
    }

    private function determineIocType($ioc)
    {
        if (filter_var($ioc, FILTER_VALIDATE_IP)) {
            return 'IP';
        } elseif (filter_var($ioc, FILTER_VALIDATE_URL)) {
            return 'URL';
        } elseif (preg_match('/^[a-f0-9]{32}$/i', $ioc)) {
            return 'MD5';
        } elseif (preg_match('/^[a-f0-9]{40}$/i', $ioc)) {
            return 'SHA1';
        } elseif (preg_match('/^[a-f0-9]{64}$/i', $ioc)) {
            return 'SHA256';
        } else {
            return 'Domain';
        }
    }

    private function encodeUrl($url)
    {
        // URL-safe base64 encoding
        return rtrim(strtr(base64_encode($url), '+/', '-_'), '=');
    }


    // public function checkIocReputation(Request $request)
    // {
        
    //     // Validate that at least one input is provided
    //     $request->validate([
    //         'single_ioc' => 'nullable|string',
    //         'ioc_file' => 'nullable|file|mimes:txt,xls,xlsx,csv',
    //     ]);
    //     $iocs = [];
    //     if ($request->has('single_ioc') && $request->single_ioc) {
    //         // If the user provided a single IOC, add it to the array
    //         $iocs[] = $request->input('single_ioc');
    //     }elseif($request->hasFile('ioc_file')){
    //         // if the user provided a list in some file
    //         $file = $request->file('ioc_file');
    //         $extension = $file->getClientOriginalExtension();
        
    //         // Define supported extensions
    //         $supportedExtensions = ['txt', 'xls', 'xlsx', 'csv'];
    //         //check about the extention of the file uploaded
    //         if (!in_array($extension, $supportedExtensions)) {
    //             return redirect()->back()->withErrors(['error' => 'Unsupported file type. Please upload a .txt, .xls, .xlsx, or .csv file.']);
    //         }

    //         if ($extension === 'txt') {
    //             $iocs = file($file->getRealPath(), FILE_IGNORE_NEW_LINES);
    //         } else {
    //             $iocs = Excel::toArray(new IocImport, $file)[0];
    //             // Flatten the array in case the data is in multiple columns/rows
    //             $iocs = array_map('reset', $iocs);
    //         }
    //     }else {
    //         return redirect()->back()->withErrors(['error' => 'Please provide an IP, URL, domain, or upload a file.']);
    //     }
        

    //     $apiKey = env('VIRUSTOTAL_KEY');
    //     $results = [];

    //     foreach ($iocs as $ioc) {
    //         $type = $this->detectIocType($ioc);
    //         $endpoint = $this->getVirusTotalEndpoint($type);
    //         // $url = "https://www.virustotal.com/api/v3/search?query=" . urlencode($ioc);
    //         $response = Http::withHeaders([
    //             'x-apikey'=>$apiKey,
    //             'accept' => 'application/json',
    //         ])->get("https://www.virustotal.com/api/v3/ip_addresses/{$ioc}");//37.255.251.17
    //         dd($response);
    //         $data = $response->json();
    //         $results[$ioc] = [
    //             'type' => $type,
    //             'data' => $data
    //         ];
    //         // Sleep to handle rate limiting (modify as needed based on your API rate limit)
    //         sleep(2); // Example: 4 requests per minute for free API
    //     }

    //     return view('reputation-result', compact('results'));
    // }

    // private function detectIocType($ioc)
    // {
    //     // Simple detection based on format; can be enhanced
    //     if (filter_var($ioc, FILTER_VALIDATE_IP)) {
    //         return 'ip-address';
    //     } elseif (filter_var($ioc, FILTER_VALIDATE_URL)) {
    //         return 'url';
    //     } elseif (preg_match('/^[a-z0-9\-\.]+\.[a-z]{2,}$/i', $ioc)) {
    //         return 'domain';
    //     } elseif (preg_match('/^[a-f0-9]{32,64}$/i', $ioc)) {
    //         return 'file';
    //     }
    //     return 'unknown';
    // }

    // private function getVirusTotalEndpoint($type)
    // {
    //     $endpoints = [
    //         'ip-address' => 'https://www.virustotal.com/api/v3/ip_addresses/',
    //         'url' => 'https://www.virustotal.com/vtapi/v2/url/report',
    //         'domain' => 'https://www.virustotal.com/vtapi/v2/domain/report',
    //         'file' => 'https://www.virustotal.com/vtapi/v2/file/report',
    //     ];

    //     return $endpoints[$type] ?? 'https://www.virustotal.com/vtapi/v2/file/report';
    // }
}
