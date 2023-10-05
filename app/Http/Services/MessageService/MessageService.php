<?php

namespace App\Http\Services\MessageService;

class MessageService
{

    public function __construct(private MessageInterface $message){}

    public function send(){
        return $this->message->fire();
    }

}
