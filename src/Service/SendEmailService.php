<?php

namespace App\Service;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendEmailService
{
    public static function sendEmail($mrList) : void
    {
        $content = "<h1>#BalanceTaMR</h1><br><h2>Bonjour !\nVoici les merge requests restantes à ce jour :</h2>";

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
            ->setPassword('Itemaster666');

        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message('Bilan journalier - #BalanceTaMR'))
            ->setFrom(['maxence.lavenu@edu.itescia.fr' => '#BalanceTaMR'])
            ->setTo(['lecarp@hotmail.fr', 'maxence.lavenu@edu.itescia.fr' => 'L\'équipe'])
            ->setBody($content, 'text/html')
        ;

        $mailer->send($message);
    }
}