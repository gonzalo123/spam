<?php

class MailEventTest extends PHPUnit_Framework_TestCase
{
    public function testMailEvent()
    {
        $event = new MailEvent\Sent('mail@mail.com');
        $this->assertEquals('mail@mail.com', $event->getTo());
    }

    public function testErrorEvent()
    {
        $event = new MailEvent\Error('mail@mail.com', new \Exception("Something wrong happens"));
        $this->assertEquals('mail@mail.com', $event->getTo());
        $this->assertInstanceOf('Exception', $event->getException());
    }
}