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
            'ssdeep' => $attributes['ssdeep'] ?? null,
            'last_analysis_results' => $attributes['last_analysis_results'] ?? [],//type array of arrays (antivirus)

            'last_modification_date' => $attributes['last_modification_date'] ?? null,
            'first_submission_date' => $attributes['first_submission_date'] ?? null,
            'tlsh' => $attributes['tlsh'] ?? null,
            'vhash' => $attributes['vhash'] ?? null,
            'type_tag' => $attributes['type_tag'] ?? null,
            'meaningful_name' => $attributes['meaningful_name'] ?? null,
            'sha256' => $attributes['sha256'] ?? null,
            'md5' => $attributes['md5'] ?? null,
            'size' => $attributes['size'] ?? null,
            'type_description' => $attributes['type_description'] ?? null,

            'last_analysis_stats' => $attributes['last_analysis_stats'] ?? null,  /// array the values is
            // "malicious" => 27
            // "suspicious" => 0
            // "undetected" => 39
            // "harmless" => 0
            // "timeout" => 0       
            // "confirmed-timeout" => 0
            // "failure" => 0
            // "type-unsupported" => 12
            'type_extension'=> $attributes['type_extension'] ?? null,

            'names'=> $attributes['names'] ?? null,  //array type 
            'sha1'=> $attributes['sha1'] ?? null,
            'meaningful_name'=> $attributes['meaningful_name'] ?? null,
            'first_seen_itw_date'=> $attributes['first_seen_itw_date'] ?? null,
            
            // Add more fields as needed
        ];
    }
}
