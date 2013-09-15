<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CommnadTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $parser = $this->getMockBuilder('Parser')->disableOriginalConstructor()->getMock();
        $parser->expects($this->any())->method('getData')->will($this->returnValue([]));

        $dispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcher')->disableOriginalConstructor()->getMock();
        $spammer = $this->getMockBuilder('Spammer')->disableOriginalConstructor()->getMock();

        $application = new Application();

        $command = new SpamCommand();
        $command->setParser($parser);
        $command->setDispatcher($dispatcher);
        $command->setSpammer($spammer);

        $application->add($command);

        $command = $application->find('spam:run');

        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        $display = $commandTester->getDisplay();
        $this->assertRegExp('/Sending mails .../', $display);
        $this->assertRegExp('/End/', $display);
    }
}