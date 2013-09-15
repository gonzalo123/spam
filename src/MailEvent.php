<?php

use Symfony\Component\EventDispatcher\Event;


class MailEvent extends Event
{
    const EVENT_MAIL_SENT = 'mail.sent';
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