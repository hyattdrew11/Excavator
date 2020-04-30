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
        $string = '';
        $fileName = 'Report-'.$date.'.csv';  
        $filePath = storage_path() . '/app/'.$fileName;
        //Decode the JSON and convert it into an associative array.
        $jsonDecoded = json_decode($this->report, true);
        $numItems = count($jsonDecoded);
        $i = 0;
        // REPORTS
        foreach($jsonDecoded['reports'] as $row) {
            $string .= '"'.$row['header'].'",';
            $childCount = count($row['child']);
            if($childCount > 0) {
                $string .= '"'.$row['child'][0]['header'].'",';
            }
        }
         // KEYS
        foreach($jsonDecoded['keys'] as $row) {
                $string .= '"'.$row['label'].'",';
        }
        // BRANDS
        foreach($jsonDecoded['brands'] as $row) {
            $string .= '"'.$row['header'].'",';
        }
         // PII HEADERS
        $pii = $jsonDecoded['pii'];
        $string .= '"'.$pii['include']['header'].'",';
        $string .= '"PIIFileName",';
        $string .= '"PIIPassword"';
        $string .= "\n";

        foreach($jsonDecoded['reports'] as $row){
           if($row['value'] == 1) {
              $string .= "true,";
           }
           else {
             $string .= "false,";
           }
            $childCount = count($row['child']);
            if($childCount > 0) {
                if($row['child'][0]['value'] == 1) {
                    $string .= "true,";
                }
                else {
                    $string .= "false,";
                }
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
            if($row['value'] == 1) {
              $string .= "true,";
           }
           else {
             $string .= "false,";
           }
        }
        if($pii['include']['value'] == 1) {
             $string .= "true,";
         }
        else {
             $string .= "true,";
        }
        $string .= '"'.$pii['PIIFileName'].'",';
        $string .= '"'.$pii['PIIPassword'].'"';

        \Storage::disk('local')->put($fileName, $string);

        return $this->view('mail.report')
            ->with(['report' => $this->report])
            ->attach($filePath, [
                'as' => $fileName,
                'mime' => 'application/csv',
            ]);
    }
}
