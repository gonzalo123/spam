<?php

namespace MailEvent;

use Symfony\Component\EventDispatcher\Event;

class Error extends Event
{
    private $to;
    private $exception;

    public function __construct($to, \Exception $exception)
    {
        $this->to        = $to;
        $this->exception = $exception;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getException()
    {
        return $this->exception;
    }
}