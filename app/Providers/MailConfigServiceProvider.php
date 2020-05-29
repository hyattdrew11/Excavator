<?php

namespace App\Providers;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (\Schema::hasTable('smtp')) {
            $mail = DB::table('smtp')->first();
            if ($mail) 
            {
                $config = array(
                    'driver'           => 'smtp',
                    'host'             => $mail->host,
                    'port'             => $mail->port,
                    'from'             => array('address' => $mail->from_address, 'name' => $mail->from_name),
                    'encryption'       => 'tls',
                    'username'         => $mail->username,
                    'password'         => $mail->password,
                );
                Config::set('mail', $config);
            }
        }
    }
}