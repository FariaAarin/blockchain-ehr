<?php

namespace App\Http\Controllers;

use App\Models\Pathology;
use Illuminate\Http\Request;

class PathologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pathologyes = Pathology::all();
        
        return view('pathology', compact('pathologyes'));
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
        $pathology = new Pathology();
        
        $pathology->name = $request->name;
        $save = $pathology->save();

        if($save){
            return back()->with('success', 'Save Successfully');
        }else{
            return back()->with('error', 'Save Failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pathology  $pathology
     * @return \Illuminate\Http\Response
     */
    public function show(Pathology $pathology)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pathology  $pathology
     * @return \Illuminate\Http\Response
     */
    public function edit(Pathology $pathology)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pathology  $pathology
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pathology $pathology)
    {
        $pathology = Pathology::find($request->id);

        $pathology->name = $request->name;
        $update = $pathology->save();

        if($update){
            return back()->with('success', 'Update Successfully');
        }else{
            return back()->with('error', 'Update Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pathology  $pathology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Pathology $pathology)
    {
        $pathology = Pathology::find($request->id);
        $delete = $pathology->delete();

        if($delete){
            
            return response()->json(['status' => 'success', 'title' => 'success', "message" => "Successfully Delete"]);
        }else{
            
            return response()->json(['status' => 'danger', 'title' => 'error', "message" => "Delete Failed"]);
        }
    }
}
