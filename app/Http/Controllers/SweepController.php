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
    
    public function sweeping(Request $req){

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
}
