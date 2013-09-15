<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class SpamCommand extends Command
{
    private $parser;
    private $dispatcher;

    protected function configure()
    {
        $this->setName('spam:run')
            ->setDescription('Send Emails');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Sending mails ...");
        $this->dispatcher->addListener(MailEvent::EVENT_MAIL_SENT, function (MailEvent $event) use ($output) {
                $output->writeln("<info>Mail sent to</info>: <fg=black;bg=cyan>{$event->getTo()}</fg=black;bg=cyan>");
            }
        );

        $this->spammer->sendEmails($this->parser->getData());
        $output->writeln("End");
    }

    public function setSpammer(Spammer $spammer)
    {
        $this->spammer = $spammer;
    }

    public function setParser(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function setDispatcher(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
}