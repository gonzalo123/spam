<?php

use Symfony\Component\EventDispatcher\EventDispatcher;

class Spammer
{
    private $twig;
    private $mailer;
    private $dispatcher;

    function __construct(Twig_Environment $twig, Mailer $mailer, EventDispatcher $dispatcher)
    {
        $this->twig       = $twig;
        $this->mailer     = $mailer;
        $this->dispatcher = $dispatcher;
    }

    public function sendEmails($data)
    {
        foreach ($data as $item) {
            $to = $item['email'];

            $this->mailer->sendMessage($to, $this->twig->render('mail.twig', $item));
            $this->dispatcher->dispatch(MailEvent::EVENT_MAIL_SENT, new MailEvent($to));
        }
    }
}