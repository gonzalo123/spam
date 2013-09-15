<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SpamCommand extends Command
{
    private $parser;
    private $twig;
    private $mailer;

    protected function configure()
    {
        $this->setName('spam:run')
            ->setDescription('Send Emails')
            ->addOption(
                'nomail',
                null,
                InputOption::VALUE_NONE,
                'Do not sent real mails'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Sending mails ...");

        if ($input->getOption('nomail')) {
            $output->writeln("You are using the nomail mode. Mails will not sent");
            $this->mailer->setNoMail(true);
        }

        foreach ($this->parser->getData() as $item) {
            $to = $item['email'];

            $this->mailer->sendMessage($to, $this->twig->render('mail.twig', $item));
            $output->writeln("<info>Mail sent to</info>:<fg=black;bg=cyan>{$to}</fg=black;bg=cyan>");
        }

        $output->writeln("End");
    }

    public function setMailer(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function setParser(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function setTwig(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }
}