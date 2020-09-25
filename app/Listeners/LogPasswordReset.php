<?php

namespace App\Listeners;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

use App\Smtp;
use App\Mail\UserActivated;
use Mail;

class LogPasswordReset
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //Welcome
    }

    /**
     * Handle the event.
     *
     * @param  PasswordReset  $event
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        $user = $event->user;
        $mail = \App\Smtp::where('active', 1)->first();

        \Mail::to($user->email)->send(new UserActivated($user));

        return redirect('home');
    }
}
