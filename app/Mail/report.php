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
    public function __construct($report, $subject)
    {
        // $this->user = $user;
        $this->report = $report;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $date = date("Ymd");
        $string = '';
        $fileName = $date.'_Excavator_Report.csv';  
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
                $string .= '"'.$row['header'].'",';
        }
        // ADDRESS
        foreach($jsonDecoded['addresses'] as $row) {
                $string .= '"'.$row['header'].'",';
        }
        // BRANDS
        foreach($jsonDecoded['brands'] as $row) {
            $string .= '"'.$row['header'].'",';
        }
         // PII HEADERS
        $pii = $jsonDecoded['pii'];
        $string .= '"'.$pii['include']['header'].'",';
        $string .= '"PIIFileName",';
        $string .= '"PIIPassword",';
        $string .= '"Requester"';
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
        // KEYS VALUES
        foreach($jsonDecoded['keys'] as $row){
            $childCount = count($row['child']);
            if($childCount > 0) {
                $string .= '"' . $row['child'][0]['value'].'",';
            }
            else {
                $string .= ",";
            }
        }
        foreach($jsonDecoded['addresses'] as $row){
            $childCount = count($row['child']);
            if($childCount > 0) {
                $string .= '"' . $row['child'][0]['value'].'",';
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
        $string .= '"'.$pii['PIIPassword'].'",';
        $string .= '"'.$jsonDecoded['email'].'"';

        \Storage::disk('local')->put($fileName, $string);



        return $this->subject($this->subject)
                    ->view('mail.report')
                    ->with(['report' => $this->report])
                    ->attach($filePath, [
                        'as' => $fileName,
                        'mime' => 'application/csv',
                    ]);
    }
}
