<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class report extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($report)
    {
        // $this->user = $user;
        $this->report = $report;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        // $temp = tmpfile();
        // fwrite($temp, $this->report);
        // $metaDatas = stream_get_meta_data($temp);
        // $tmpFilename = $metaDatas['uri'];
        $date = time();
        $fileName = 'Report-'.$date.'.json';
        $filePath = storage_path() . '/app/'.$fileName;
        \Storage::disk('local')->put($fileName, $this->report);

        return $this->view('mail.report')
            ->with(['report' => $this->report])
            ->attach($filePath, [
                'as' => $fileName,
                'mime' => 'application/json',
            ]);

        // fclose($temp);
    }
}
