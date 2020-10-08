<?php

namespace App\Service;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendEmailService
{
    public static function sendEmail($mrList) : void
    {
        $content = "Voici les Merge Requetes du moment :";

        foreach ($mrList as $list){
            foreach ($list as $merge){
                $content .= " // Titre = " . $merge['title'];
            }
        }

        /** @var
         * Username : Ton adresse email
         * Password : Ton password
         * Ensuite => Dans le terminal , taper la commande : bin/console sendemail:cron
         */
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
            ->setUsername('maxence.lavenu@edu.itescia.fr')
            ->setPassword('&&');

        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message('Bilan journalier - #BalanceTaMR'))
            ->setFrom(['maxence.lavenu@edu.itescia.fr' => '#BalanceTaMR'])
            ->setTo(['lecarp@hotmail.fr', 'maxence.lavenu@edu.itescia.fr' => 'L\'équipe'])
            ->setBody($content)
        ;

        $mailer->send($message);
    }
}