<?php

namespace App\Service;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendEmailService
{
    public static function sendEmail($mrList) : void
    {
        $transport = new Swift_SmtpTransport('localhost', 25);

        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message('Wonderful Subject'))
            ->setFrom(['lecarp@hotmail.fr' => 'John Doe'])
            ->setTo(['lecarp@hotmail.fr', 'other@domain.org' => 'A name'])
            ->setBody('Here is the message itself')
        ;

        $mailer->send($message);
    }
}