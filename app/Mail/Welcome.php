<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;


class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('mail.welcome');
        $credentials = ['email' => $this->user->email];
        $response = Password::sendResetLink($credentials, function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        // switch ($response) {
        //     case Password::RESET_LINK_SENT:
        //         return redirect('users')->with('success', trans('laravelusers::laravelusers.messages.user-creation-success'));
        //         // return redirect()->back()->with('status', trans($response));

        //     case Password::INVALID_USER:
        //         return redirect()->back()->withErrors(['email' => trans($response)]);
        // }
    }
}
