<?php

namespace App\Http\Services\Message\Email;

use App\Http\Services\Message\Interfaces\MessageInterface;
use App\Http\Services\Message\MessageService;
use Illuminate\Support\Facades\Mail;


class EmailService implements MessageInterface
{

    private $details;
    private $subject;
    private $from = [
       ['address' => null, 'name' => null]
    ];
    private $to;
    private $objectName;

    public function __construct(){
        $this->from(config('mail.from.address'), config('mail.from.name'));
        $this->subject(config('mail.subject'));
    }


    public function fire(){
        Mail::to($this->getTo())->send(new $this->objectName($this->getDetails(), $this->getSubject(), $this->getFrom()));
        return true;
    }

    public function mailClass($className){
        $this->objectName = $className;
        return $this;
    }

    private function getDetails(){
        return $this->details;
    }

    public function details($details)
    {
        $this->details = $details;
        return $this;
    }

  private function getSubject(){
        return $this->subject;
    }

    public function subject($subject)
    {
        $this->subject = $subject;
        return $this;
    }


  private function getFrom(){
        return $this->from;
    }

    public function from($address, $name)
    {
        $this->from = [
            [
                'address' => $address,
                'name' => $name
            ]
        ];
        return $this;
    }

    private function getTo(){
        return $this->to;
    }

    public function to($to)
    {
        $this->to = $to;
        return $this;
    }





}
