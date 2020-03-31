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
        //
    }

    /**
     * Handle the event.
     *
     * @param  PasswordReset  $event
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        $mail = \App\Smtp::where('active', 1)->first();
        $user = $event->user;
        \Config::set('MAIL_HOST', $mail->host);
        \Config::set('MAIL_PORT', $mail->port);
        \Config::set('MAIL_USERNAME', $mail->username);
        \Config::set('MAIL_PASSWORD', $mail->password);
        \Config::set('MAIL_FROM_ADDRESS', 'drew@thearchengine.com');
        \Config::set('MAIL_FROM_NAME', 'Drew Hyatt');
        \Mail::to('drew@thearchengine.com')->send(new UserActivated($user));
        error_log("SUCCESSFUL PASSWORD RESET");
        return redirect('home');
    }
}
