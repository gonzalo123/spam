<?php

use Symfony\Component\EventDispatcher\Event;

class MailEvent extends Event
{
    const EVENT_MAIL_SENT  = 'mail.sent';
    const EVENT_SENT_ERROR = 'mail.error';
}