<?php

namespace App\Http\Services\MessageService;

use App\Http\Services\Message\Interfaces\MessageInterface;

class MessageService
{

    public function __construct(private MessageInterface $message){}

    public function send(){
        return $this->message->fire();
    }

}
