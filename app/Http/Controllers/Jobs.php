<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Job;
use App\Mail\report;
use Mail;
class Jobs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) 
    {
        // TRY CATCH ADD JOB TO JOB TABLE WITH USER ID
        // SEND EMAIL BASED ON JOB FORM
        // RETURN JOB TO USER 
        $user   = Auth::user()->hasRole('user');
        $admin  = Auth::user()->hasRole('admin');
        if($user || $admin) {
            $user_id = Auth::user()->id;
            $Job = new Job();
            $Job->user_id = $user_id;
            $Job->form = $request->getContent();
            $Job->save();

            $report = $request->getContent();

            $data = array('report'=> $request);
            
            $mail = \App\Smtp::where('active', 1)->first();

            $subject = $mail->subject;

            \Mail::to($mail->target_email)->send(new report($report, $subject));

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
    public function show($id)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
