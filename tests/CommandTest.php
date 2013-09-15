<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CommnadTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $parser = $this->getMockBuilder('Parser')->disableOriginalConstructor()->getMock();
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
        $parser->expects($this->any())->method('getData')->will($this->returnValue($data));

        $twig = $this->getMockBuilder('Twig_Environment')->disableOriginalConstructor()->getMock();
        $twig->expects($this->any())->method('render')->will($this->returnValue(true));

        $mailer = $this->getMockBuilder('Mailer')->disableOriginalConstructor()->getMock();

        $application = new Application();

        $command = new SpamCommand();
        $command->setParser($parser);
        $command->setTwig($twig);
        $command->setMailer($mailer);

        $application->add($command);

        $command = $application->find('spam:run');

        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        $this->assertRegExp('/Sending mails .../', $commandTester->getDisplay());
        $this->assertRegExp('/Mail sent to:mail@mail.com/', $commandTester->getDisplay());
        $this->assertRegExp('/Mail sent to:superman@mail.com/', $commandTester->getDisplay());
        $this->assertRegExp('/End/', $commandTester->getDisplay());
    }
}