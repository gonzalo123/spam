<?php

class MailerTest extends \PHPUnit_Framework_TestCase
{
    public function test_mailer()
    {
        $swiftMailer = $this->getMockBuilder('Swift_Mailer')->disableOriginalConstructor()->getMock();
        $swiftMailer->expects($this->any())->method('send')->will($this->returnValue(true));
        $swiftMessage = $this->getMockBuilder('Swift_Message')->disableOriginalConstructor()->getMock();

        $mailer = new Mailer($swiftMailer, $swiftMessage);

        $this->assertTrue($mailer->sendMessage("to@mail.com", "message body"));
    }

    public function test_mailer_with_no_mail_option()
    {
        $swiftMailer = $this->getMockBuilder('Swift_Mailer')->disableOriginalConstructor()->getMock();
        $swiftMailer->expects($this->any())->method('send')->will($this->returnValue(true));
        $swiftMessage = $this->getMockBuilder('Swift_Message')->disableOriginalConstructor()->getMock();

        $mailer = new Mailer($swiftMailer, $swiftMessage);
        $mailer->setNoMail(true);

        $this->assertFalse($mailer->sendMessage("to@mail.com", "message body"));
    }
}