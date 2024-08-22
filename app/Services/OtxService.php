<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OtxService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('OTX_KEY');
        $this->baseUrl = 'https://otx.alienvault.com/api/v1';
    }

    public function searchPulses($query)
    {
        $url = $this->baseUrl . '/pulses/subscribed?limit=10&q=' . urlencode($query);
        $response = Http::withHeaders([
            'X-OTX-API-KEY' => $this->apiKey,
        ])->get($url);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => true,
            'message' => 'Failed to fetch pulses from OTX.',
        ];
    }

    public function getPulseDetails($pulseId)
    {
        $url = $this->baseUrl . '/pulses/' . $pulseId;
        $response = Http::withHeaders([
            'X-OTX-API-KEY' => $this->apiKey,
        ])->get($url);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => true,
            'message' => 'Failed to fetch pulse details from OTX.',
        ];
    }

    // Search\Pulses
    // Method to search pulses based on a query
    public function searchPulses2($query)
    {
        try {
            $url = $this->baseUrl . 'search/pulses';
            $response = Http::withHeaders([
                    'X-OTX-API-KEY' => $this->apiKey,])->get($url,[
                        'q' => $query, // The search query parameter
                    ]);
                    
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

}
