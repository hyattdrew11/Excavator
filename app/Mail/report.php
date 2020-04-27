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
        //Loop through the associative array.
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
            if(++$i === $numItems) {
                $string .= '"'.$row['label'].'",'."\n";
            }
            else {
                $string .= '"'.$row['label'].'",';
            }
        }

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
 
        \Storage::disk('local')->put($fileName, $string);

        return $this->view('mail.report')
            ->with(['report' => $this->report])
            ->attach($filePath, [
                'as' => $fileName,
                'mime' => 'application/json',
            ]);
    }
}
