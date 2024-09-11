<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ThreatfoxService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('THREATFOX_KEY');
        $this->baseUrl = 'https://threatfox-api.abuse.ch/api/v1/';
    }
    // searching using threat fox
    
    public function search($malwareFamily)
    {
        try {
            // Prepare the request data
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl, [
                'query' => 'malwareinfo',
                'malware' => $malwareFamily //"cobalt strike" // Dynamically pass the malware family
            ]);//dd($response);
            // $response = Http::post($this->baseUrl, [
            //         'query' => 'malwareinfo',
            //         'malware' => "Cobalt Strike",//$malwareFamily
            // ]);
            // Convert the response to JSON
            $data = json_decode($response->getBody()->getContents(), true);

            // Return the IOC data
            return $data['data'] ?? ['Some Thing Wrong'];

        } catch (\Exception $e) {
            // Handle errors (e.g., log them)
            \Log::error('ThreatFox API error: ' . $e->getMessage());
            return [];
        }
    }
}