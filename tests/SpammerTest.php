<?php

use Symfony\Component\EventDispatcher\EventDispatcher;

class SpammerTest extends PHPUnit_Framework_TestCase
{
    public function test_send_emails()
    {
        $dispatcher = new EventDispatcher();

        $mailSent  = false;
        $mailError = false;

        $dispatcher->addListener(MailEvent::EVENT_MAIL_SENT, function() use (&$mailSent) {
                $mailSent = true;
            });
        $dispatcher->addListener(MailEvent::EVENT_SENT_ERROR, function() use (&$mailError) {
                $mailError = true;
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
        $this->assertFalse($mailError);

        $spammer->sendEmails($data);

        $this->assertTrue($mailSent);
        $this->assertFalse($mailError);
    }

    public function test_send_emails_handling_exceptions()
    {
        $dispatcher = new EventDispatcher();

        $mailSent  = false;
        $mailError = false;

        $dispatcher->addListener(MailEvent::EVENT_MAIL_SENT, function() use (&$mailSent) {
                $mailSent = true;
            });
        $dispatcher->addListener(MailEvent::EVENT_SENT_ERROR, function() use (&$mailError) {
            $mailError = true;
            });

        $twig = $this->getMockBuilder('Twig_Environment')->disableOriginalConstructor()->getMock();
        $twig->expects($this->any())->method('render')->will($this->returnValue(true));

        $mailer = $this->getMockBuilder('Mailer')->disableOriginalConstructor()->getMock();
        $mailer->expects($this->at(0))->method('sendMessage')->will($this->returnValue(true));
        $mailer->expects($this->at(1))->method('sendMessage')->will($this->throwException(new \Exception('Something wrong happens')));

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
        $this->assertFalse($mailError);

        $spammer->sendEmails($data);

        $this->assertTrue($mailSent);
        $this->assertTrue($mailError);
    }
}