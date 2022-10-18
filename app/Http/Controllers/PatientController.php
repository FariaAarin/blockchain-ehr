<?php

namespace App\Http\Controllers;

use App\Models\Pathology;
use App\Models\PathologyTest;
use App\Models\patient;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use File;
class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $patients = User::where('type', 3)->get();
        
        return view('patients', compact('patients'));
    }

    public function prescribe(Request $request)
    {
        
        $patients = User::where('type', 3)->get();
        $pathologyes = Pathology::all();
        
        return view('prescribe', compact('patients', 'pathologyes'));
    }

    function get_previous_hashid($chain){
        $lastEl = array_values(array_slice($chain, -1))[0];
        return $lastEl["hashid"];
    }
    
    public function get_previous_index($chain){
        $lastEl = array_values(array_slice($chain, -1))[0];
        return $lastEl["index"];
    }

    function get_previous_timestamp($chain){
        $lastEl = array_values(array_slice($chain, -1))[0];
        return $lastEl["timestamp"];
    }

    function get_previous_content($chain){
        $lastEl = array_values(array_slice($chain, -1))[0];
        return $lastEl["content"];
    }
    
    public function get_new_hashid($previous_hashid,$index,$timestamp,$content){
       $full_string = $previous_hashid.$index.$timestamp.$content;
       $hash  = hash('sha256',$full_string);
       return $hash;
    }
    
    public function read_content($content) {
       $arr_content = json_decode($content);
       return $arr_content;
    }

    public function prescribeStore(Request $request){

        $pathology = implode(",", $request->pathology);

        $fileName = $request->unique_id.'_'.$request->name.'.json';

        $path = public_path('/assets/prescriptions/'.$fileName);
   
        $isExists = File::exists($path);

        if($isExists){

            $json = json_decode(File::get(public_path('/assets/prescriptions/'.$fileName)), true);

            $previous_hashid = $this->get_previous_hashid($json['chain']);
            $previous_index = $this->get_previous_index($json['chain']);
            $previous_timestamp = $this->get_previous_timestamp($json['chain']);
            $previous_content = json_encode($this->get_previous_content($json['chain']));
            $timestamp = round(microtime(true) * 1000);

            //new hash
            $new_hashid = $this->get_new_hashid($previous_hashid, $previous_index+1, $previous_timestamp, $previous_content);

            $patientData = [
               
                "index" => $previous_index+1,
                "hashid" =>  $new_hashid,
                "timestamp" => $timestamp,
                "proof-of-work" => "xyz",
                "content" => [
                    'doctor_name' => Auth::user()->name,
                    'patient_name' => $request->name,
                    'unique_id' => $request->unique_id,
                    'details' => $request->details,
                    'pathology' => $pathology,
                    'date' => date('d-m-Y'),
                ]
            ];
    
            array_push($json['chain'], $patientData);

            $data['chain'] = $json['chain'];

            $hashValidate = $this->hashIsValid($data['chain']);

            if($hashValidate == false){
                return back()->with('error', 'Sorry ! We Fonud hashing mismatch');
            }

            $data = json_encode($data);

            $save = File::put(public_path('/assets/prescriptions/'.$fileName), $data);

            // $json = json_decode(File::get(public_path('/assets/prescriptions/'.$fileName)), true);

            if($save){
                return back()->with('success', 'Save Successfully');
            } else {
                return back()->with('error', 'Save Failed');
            }
    

        }else{

            $patientData['chain'][] = [
               
                "index" => 0,
                "hashid" => "",
                "timestamp" => round(microtime(true) * 1000),
                "proof-of-work" => "xyz",
                "content" => [
                    'doctor_name' => Auth::user()->name,
                    'patient_name' => $request->name,
                    'unique_id' => $request->unique_id,
                    'details' => $request->details,
                    'pathology' => $pathology,
                    'date' => date('d-m-Y'),
                ]
            ];
    
            $data = json_encode($patientData);
    
           $save = File::put(public_path('/assets/prescriptions/'.$fileName), $data);

            // $json = json_decode(File::get(public_path('/assets/prescriptions/'.$fileName)), true);

            if($save){
                return back()->with('success', 'Save Successfully');
            } else {
                return back()->with('error', 'Save Failed');
            }

            
        }

    }

    public function hashIsValid($data)
    {
        for ($i = 1; $i < count($data); $i++) {

            $currentBlock =  $data[$i];

            $previousBlock = $data[$i-1];

            $previousHashCalculate = $this->get_new_hashid($previousBlock['hashid'], $previousBlock['index']+1, $previousBlock['timestamp'], json_encode($previousBlock['content']));

            if ($currentBlock['hashid'] != $previousHashCalculate) {
                return false;
            }

        }


        return true;
    }


    public function prescribeList(Request $request){

        $prescriptions = Prescription::with('doctor', 'patient', 'pathologyTest', 'pathologyTest.pathology')->where('doctor_id', Auth::user()->id)->get();

        return view('prescribeList', compact('prescriptions'));
    }

    
    public function prescriptionPrint(Request $request){

        $jsonData = json_decode(File::get(public_path('/assets/prescriptions/'.$request->name)), true);

        $prescription = [];

        foreach($jsonData['chain'] as $item){

            if($item['index'] == intval($request->index)){
                $prescription = $item['content'];
            }
        }

        return view('prescriptionPrint', compact('prescription'));
    }

    



    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patient = new User();
        $patient->uniqueId = date('Y').rand ( 1000 , 9999);
        $patient->name = $request->name;
        $patient->email = $request->email;
        $patient->mobile = $request->mobile;
        $patient->type = 3;
        $patient->password =  bcrypt($request->password);

        $save = $patient->save();

        if($save){
            return back()->with('success', 'Save Successfully');
        }else{
            return back()->with('error', 'Save Failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $patient = User::find($request->id);

        $patient->name = $request->name;
        $patient->email = $request->email;
        $patient->mobile = $request->mobile;
        
        if($request->has('password')){
            $patient->password =  bcrypt($request->password);
        }

        $update = $patient->save();

        if($update){
            return back()->with('success', 'Update Successfully');
        }else{
            return back()->with('error', 'Update Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        $patient = User::find($request->id);
        $delete = $patient->delete();

        if($delete){
            
            return response()->json(['status' => 'success', 'title' => 'success', "message" => "Successfully Delete"]);
        }else{
            
            return response()->json(['status' => 'danger', 'title' => 'error', "message" => "Delete Failed"]);
        }
    }


    public function prescribeStoreOld(Request $request){
        
        DB::beginTransaction();

        try {

            $prescription = new Prescription();

            $prescription->doctor_id = Auth::user()->id;
            $prescription->patient_id = $request->id;
            $prescription->details = $request->details;

            $prescription->save();

            for($i = 0; $i < count($request->pathology); $i++){
                
                $pahtologyTest = new PathologyTest();
                $pahtologyTest->prescription_id = $prescription->id;
                $pahtologyTest->pathology_id = $request->pathology[$i];
                $pahtologyTest->save();
            }

            DB::commit();
            // all good
            return back()->with('success', 'Save Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return back()->with('error', 'Save Failed');
        }

    }
}
