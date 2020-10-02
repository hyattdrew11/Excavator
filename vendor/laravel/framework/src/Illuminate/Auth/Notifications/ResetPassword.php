<?php

namespace Illuminate\Auth\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;


class ResetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * The callback that should be used to create the reset password URL.
     *
     * @var \Closure|null
     */
    public static $createUrlCallback;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
         \Log::error($notifiable);
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            $url = url("https://toolshed.wedigdata.com".route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        }
        $imageHtml = '<img src="/img/DIG-LOGO-BIG.jpg" />';
        if($notifiable->created_at == $notifiable->updated_at) {
            \Log::error("ACTIVATE ACCOUNT");
            \Log::error($notifiable->created_at);
            \Log::error($notifiable->updated_at);
            return (new MailMessage)
                ->subject(Lang::get('Account Activation'))
                ->line(new HtmlString($imageHtml))
                ->line(Lang::get('You are receiving this email because we’ve created a new account for you. To get started, you’ll need to activate your account by setting a password.'))
                ->action(Lang::get('Set Password'), $url)
                ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                 ->line(Lang::get('If you do not want to activate your account, no further action is necessary.  If you have questions about this email, please contact your Data Intelligence Group account representative or contact us by calling 615.861.3301 x.7017'));
         }
         else {
            \Log::error("RESET PASSWORD");
            \Log::error($notifiable->created_at);
            \Log::error($notifiable->updated_at);
            return (new MailMessage)
            ->subject(Lang::get('Password Reset'))
            ->line(new HtmlString($imageHtml))
            ->line(Lang::get('You are receiving this email because you have requested a password reset. Click the link below to reset your password.'))
            ->action(Lang::get('Reset Password'), $url)
            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
             ->line(Lang::get('If you do not want to reset your password, no further action is necessary.  If you have questions about this email, please contact your Data Intelligence Group account representative or contact us by calling 615.861.3301 x.7017'));
         }

    }

    /**
     * Set a callback that should be used when creating the reset password button URL.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function createUrlUsing($callback)
    {
        static::$createUrlCallback = $callback;
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
