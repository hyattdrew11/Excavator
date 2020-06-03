<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Smtp;
use App\Mail\SmtpTest;
use Mail;

class SmtpController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) 
    {
        $user = Auth::user()->hasRole('admin');
        if($user) {
            $connection = new Smtp();
            $connection->name = 'Smtp Connection';
            $connection->host = $request->host;
            $connection->port = $request->port;
            $connection->username = $request->username;
            $connection->password = $request->password;
            $connection->from_address = $request->from_address;
            $connection->from_name = $request->from_name;
            $connection->encryption = 'tls';
            $connection->active = 'false';
            $connection->save();
            return response($connection, Response::HTTP_OK);
        }
        else {
            return "ERROR";
        }
    }
    public function update(Request $request) 
    {
        $user = Auth::user()->hasRole('admin');
        if($user) {
            $id = $request->id;
            $connection = \App\Smtp::where('id', $id)->first();
            $connection->name = 'Smtp Connection';
            $connection->host = $request->host;
            $connection->port = $request->port;
            $connection->username = $request->username;
            $connection->password = $request->password;
            $connection->from_address = $request->from_address;
            $connection->subject = $request->subject;
            $connection->from_name = $request->from_name;
            $connection->target_email = $request->target_email;
            $connection->encryption = 'tls';
            $connection->active = 1;
            $connection->update();
            return response($connection, Response::HTTP_OK);
        }
        else {
            return "ERROR";
        }
    }
    public function delete(Request $request) 
    {
        $user = Auth::user()->hasRole('admin');
        if($user) {
            $id = $request->id;
            \App\Smtp::destroy($id);
            return response($id, Response::HTTP_OK);
        }
        else {
            return "ERROR";
        }
    }
    public function test(Request $request)
    {
        $user = Auth::user()->hasRole('admin');
    	if($user) {
            var_dump($request);
            $mail = \App\Smtp::where('active', 1)->first();

            \Mail::to($request->email)->send(new SmtpTest($request));

            return response($request, Response::HTTP_OK);
        }
        else {
            return "ERROR";
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $admin      = Auth::user()->hasRole('admin');
        $connections = DB::table('smtp')->get();
        if($admin)    { 
            return view('admin-home', ['connections' => $connections] );  
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
