<?php

namespace MailEvent;

use Symfony\Component\EventDispatcher\Event;

class Sent extends Event
{
    private $to;

    public function __construct($to)
    {
        $this->to = $to;
    }

    public function getTo()
    {
        return $this->to;
    }
}