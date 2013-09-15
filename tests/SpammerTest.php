<?php

use Symfony\Component\EventDispatcher\EventDispatcher;

class SpammerTest extends PHPUnit_Framework_TestCase
{
    public function test_send_emails()
    {
        $dispatcher = new EventDispatcher();
        $mailSent = false;
        $dispatcher->addListener(MailEvent::EVENT_MAIL_SENT, function() use (&$mailSent) {
                $mailSent = true;
            });

        $twig = $this->getMockBuilder('Twig_Environment')->disableOriginalConstructor()->getMock();
        $twig->expects($this->any())->method('render')->will($this->returnValue(true));

        $mailer = $this->getMockBuilder('Mailer')->disableOriginalConstructor()->getMock();
        $mailer->expects($this->any())->method('sendMessage')->will($this->returnValue(true));

        $spammer = new Spammer($twig, $mailer, $dispatcher);

        $data   = [
            [
                'name'  => 'Gonzalo',
                'email' => 'mail@mail.com',
                'body'  => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
            ],
            [
                'name'  => 'Clark',
                'email' => 'superman@mail.com',
                'body'  => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
            ],
        ];

        $this->assertFalse($mailSent);
        $spammer->sendEmails($data);
        $this->assertTrue($mailSent);
    }
}