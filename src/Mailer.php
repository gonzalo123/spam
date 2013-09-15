<?php

class Mailer
{
    private $swiftMailer;
    private $swiftMessage;
    private $noMail = false;

    public function setNoMail($noMail)
    {
        $this->noMail = (boolean)$noMail;
    }

    function __construct(Swift_Mailer $swiftMailer, Swift_Message $swiftMessage)
    {
        $this->swiftMailer  = $swiftMailer;
        $this->swiftMessage = $swiftMessage;
    }

    public function sendMessage($to, $body)
    {
        $this->swiftMessage->setTo($to);
        $this->swiftMessage->setBody($body);

        return $this->noMail ? false : $this->swiftMailer->send($this->swiftMessage);
    }
}