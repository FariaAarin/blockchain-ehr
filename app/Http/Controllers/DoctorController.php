<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\User;
// use Symfony\Component\HttpFoundation\File\File;
use File;
class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $doctors = User::where('type', 2)->get();
        
        return view('doctors', compact('doctors'));
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
        $doctor = new User();
        $doctor->name = $request->name;
        $doctor->email = $request->email;
        $doctor->mobile = $request->mobile;
        $doctor->type = 2;
        $doctor->password =  bcrypt($request->password);

        $update = $doctor->save();

        if($update){
            return back()->with('success', 'Save Successfully');
        }else{
            return back()->with('error', 'Save Failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctor $doctor)
    {
        $doctor = User::find($request->id);

        $doctor->name = $request->name;
        $doctor->email = $request->email;
        $doctor->mobile = $request->mobile;
        
        if($request->has('password')){
            $doctor->password =  bcrypt($request->password);
        }

        $update = $doctor->save();

        if($update){
            return back()->with('success', 'Update Successfully');
        }else{
            return back()->with('error', 'Update Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor, Request $request)
    {
        
        $doctor = User::find($request->id);
        $delete = $doctor->delete();

        if($delete){
            
            return response()->json(['status' => 'success', 'title' => 'success', "message" => "Successfully Delete"]);
        }else{
            
            return response()->json(['status' => 'danger', 'title' => 'error', "message" => "Delete Failed"]);
        }
    }
}
