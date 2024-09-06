<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Process;
use Illuminate\Http\Request;
use App\Models\Indicator;
use App\Models\Malwarefamily;

class SweepController extends Controller
{
    public function index(){
        $malwareFamilies = Malwarefamily::all();
        return view('sweep', compact('malwareFamilies'));
    }
    
    public function old_sweeping(Request $req){

        // get data from data base about ioc
        $iocs = Indicator::where('malwarefamilies_id',$req->selected_malware)->get();
        $json = $iocs->toJson();//  Transform the result to json type
        
        // search about this data in the local drive
        // Define the path to the PowerShell script
        $psScriptPath = storage_path('app/array.ps1');
        // Build the PowerShell command with JSON data passed as an argument
        $command = 'powershell -File "' . $psScriptPath . '" -jsonData \'' . addslashes($json) . '\'';
        
        // Execute the PowerShell script
        $output = shell_exec($command);
        if(!empty($output)){
            return response()->json(['output' => $output]);
        }
        return response()->json(['output' => 'Your Local Network Save from This Attack!' ]);

        // print the result on the screen
    }

    //sweeping Network through api and integrating with python
    public function sweeping(Request $req){
        //$req->selected_malware
        $iocs = Indicator::where('malwarefamilies_id',$req->selected_malware)->get();
        $json = json_decode($iocs->toJson(), true);
        // dd($json);
        $ioc_req_json = $this->covertJson($json);//->getContent();
       // dd($ioc_req_json);
        try {
            $response = Http::timeout(360)->post('http://127.0.0.1:5000/api/json_str', $ioc_req_json);
            
            if ($response->successful()) {
                \Log::info('API Request: ', ['url' => 'http://127.0.0.1:5000/api/json_str', 'data' => $ioc_req_json]);
                \Log::info('API Response: ', ['response' => $response->body()]);
                return response()->json(['status' => 'success', 'message' => 'API connection successful','result'=> $response->body()]);
                
            } else {
                return response()->json(['status' => 'error', 'message' => 'API connection failed: ' . $response->body()], $response->status());
            }

        } catch (Exception  $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not connect to the API: ' . $e->getMessage()], 500);
        }
        // return response()->json(['status' => 'success', 'result'=>$json ]);
        // dd(json_decode($response->body(), true));

    }
    private function covertJson($json){
        // Initialize an empty array to store indicators
        $indicators = [];
        // dd($json);
        // Add the suspiciousConnections object to the indicators array
        $indicators[] = [
            'type' => 'IPv4',
            'indicator' => '54.84.102.116',
        ];
        // Iterate through the 'result' array and construct the new structure
        foreach ($json as $item) {
           
            $indicators[] = [
                'type' => $item['type'],
                'indicator' => $item['value']
            ];
        }
        
        // Create the new JSON structure
        $newJson = [
            'res' => [
                
                    'indicators' => $indicators
                
            ]
        ];
        

        // Return the new JSON as a response
        return  $newJson;//response()->json();
    }
}
