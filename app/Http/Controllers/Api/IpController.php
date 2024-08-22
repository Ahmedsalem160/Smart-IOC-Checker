<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IpController extends Controller
{
    public function ip(){
        $response = Http::withHeaders([
            'X-OTX-API-KEY' => env('OTX_KEY'),
            'Content-Type'  => 'application/json',
        ])->get('https://otx.alienvault.com/api/v1/indicators/IPv4/8.8.8.8/general');
        if ($response->successful()) {
            $data = $response->json();
            // Handle the response data
        } else {
            Log::error('OTX API request failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            // Handle the error appropriately
        }
    }
    
}

