<?php

class MailEventTest extends PHPUnit_Framework_TestCase
{
    public function testMailEvent()
    {
        $event = new MailEvent('mail.mail.com');
        $this->assertEquals('mail.mail.com', $event->getTo());
    }
}