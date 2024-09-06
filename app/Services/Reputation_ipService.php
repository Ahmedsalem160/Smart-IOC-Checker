<?php

namespace App\Services;

class Reputation_fileService
{
    public function handleReputationData(array $data)
    {
        // Extract relevant information from the data
        $attributes = $data['data']['attributes'] ?? [];

        return [
            'id' => $data['data']['id'] ?? null,
            'type' => $data['data']['type'] ?? null,
            'self_link' => $data['data']['links']['self'] ?? null,
            'last_https_certificate_date' => $attributes['last_https_certificate_date'] ?? null,
            'reputation' => $attributes['reputation'] ?? null,
            'country' => $attributes['country'] ?? null,
            'continent' => $attributes['continent'] ?? [],
            'last_modification_date' => $attributes['last_modification_date'] ?? null,
            'whois_date' => $attributes['whois_date'] ?? null,
            'regional_internet_registry' => $attributes['regional_internet_registry'] ?? null,
            'jarm' => $attributes['jarm'] ?? null,
            'as_owner' => $attributes['as_owner'] ?? null,
            'whois' => $attributes['whois'] ?? null,    // as paragraph
            'network' => $attributes['network'] ?? null,
            'md5' => $attributes['md5'] ?? null,
            'size' => $attributes['size'] ?? null,
            'type_description' => $attributes['type_description'] ?? null,

            'last_analysis_stats' => $attributes['last_analysis_stats'] ?? null,  /// array the values is
            // "malicious" => 27
            // "suspicious" => 0
            // "undetected" => 39
            // "harmless" => 0
            // "timeout" => 0        ==== the result of ip لحد هنا  
            // "confirmed-timeout" => 0
            // "failure" => 0
            // "type-unsupported" => 12
            'asn'=> $attributes['asn'] ?? null,

            'last_analysis_results'=> $attributes['last_analysis_results'] ?? null,  //array type 
        //     "Acronis" => array:4 [▼
        //     "method" => "blacklist"
        //     "engine_name" => "Acronis"
        //     "category" => "harmless"
        //     "result" => "clean"
        //   ]                                  sample of res
        //   "0xSI_f33d" => array:4 [▼
        //     "method" => "blacklist"
        //     "engine_name" => "0xSI_f33d"
        //     "category" => "undetected"
        //     "result" => "unrated"
        //   ]
        //   "Abusix" => array:4 [▶]
            'last_https_certificate'=> $attributes['last_https_certificate'] ?? null, // array type

        //     "cert_signature" => array:2 [▶]
        // "extensions" => array:9 [▶]
        // "validity" => array:2 [▶]
        // "size" => 1666
        // "version" => "V3"
        // "public_key" => array:2 [▶]
        // "thumbprint_sha256" => "0a635fee1dcadbdbe3d6d5810a735fb64b38e84e032951911aca391beb38491b"
        // "thumbprint" => "dfd9961473cf4a416c238523399b4a74dcb9d91c"
        // "serial_number" => "abf706a4c59582f8ea2f6df6eac44a4f"
        // "issuer" => array:3 [▶]
        // "subject" => array:1 [▶]

            
            // Add more fields as needed
        ];
    }
}
