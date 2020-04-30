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

        $date = time();
        $fileName = 'Report-'.$date.'.csv';
        $filePath = storage_path() . '/app/'.$fileName;
        $string = '';
        //Decode the JSON and convert it into an associative array.
        $jsonDecoded = json_decode($this->report, true);
        $numItems = count($jsonDecoded);
        $i = 0;
        // REPORTS
        foreach($jsonDecoded['reports'] as $row) {
            $string .= '"'.$row['label'].'",';
            $childCount = count($row['child']);
            if($childCount > 0) {
                $string .= '"'.$row['child'][0]['label'].'",';
            }
        }
         // KEYS
        foreach($jsonDecoded['keys'] as $row) {
                $string .= '"'.$row['label'].'",';
        }
        // BRANDS
        foreach($jsonDecoded['brands'] as $row) {
            $string .= '"'.$row['label'].'",';
        }
         // PII HEADERS
        $pii = $jsonDecoded['pii'];
        $string .= '"'.$pii['include']['label'].'",';
        $string .= '"fileName",';
        $string .= '"password"';
        $string .= "\n";

        foreach($jsonDecoded['reports'] as $row){
           
            $string .= $row['value'].",";
            $childCount = count($row['child']);
            if($childCount > 0) {
                $string .= $row['child'][0]['value'].",";
            }
        }
        foreach($jsonDecoded['keys'] as $row){
            $childCount = count($row['child']);
            if($childCount > 0) {
                $string .= $row['child'][0]['value'].",";
            }
            else {
                $string .= ",";
            }
        }
        foreach($jsonDecoded['brands'] as $row){
                $string .= $row['value'].",";
        }
        $string .= '"'.$pii['include']['value'].'",';
        $string .= '"'.$pii['fileName'].'",';
        $string .= '"'.$pii['password'].'"';

        if (is_null($pii['fileName'])){ }
        else {
            $fileName = $pii['fileName'].'.csv';
        }
 
        \Storage::disk('local')->put($fileName, $string);

        return $this->view('mail.report')
            ->with(['report' => $this->report])
            ->attach($filePath, [
                'as' => $fileName,
                'mime' => 'application/json',
            ]);
    }
}
