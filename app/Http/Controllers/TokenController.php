<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;


class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function generate(Request $request){

        $token = Token::orderBy('serial', 'desc')->first();
        
        $serial = (!empty($token)) ? $token->serial : 0;

        for($i=1; $i <= $request->quantity; $i++){

            Token::insert(['serial' => $serial + $i, 'created_at' => date('Y-m-d h:i:s')]);   

        }
        
        return back()->with('message', 'Successfully Token Generated');
        
    }

    public function print(Request $request){

        $from = (isset($request->from)) ? $request->from : 0;
        $to = (isset($request->to)) ? $request->to : 0;


        $data = Token::whereBetween('serial', [$from, $to])->get();

        return view('token_print', compact('data', 'from', 'to'));
    }

    public function single_token(Request $request){

        $data = Token::where('status', 0)->first();
        
        return view('single_token', compact('data'));

    }

    public function token_complete(Request $request){

        $data = [
            'details' => $request->details,
            'status' => 1,
            'updated_at' => date('Y-m-d h:i:s')
        ];

        $update = Token::where('serial', $request->serial)->update($data);

        if($update){
            return response()->json(['status' => 'success', "message" => "টোকেন কমপ্লিট"]);
        }else{
            return response()->json(['status' => 'error', "message" => "দুঃখিত ! টোকেন কমপ্লিট হয়নি।"]);
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function show(Token $token)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function edit(Token $token)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Token $token)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function destroy(Token $token)
    {
        //
    }
}
