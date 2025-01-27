<?php

namespace App\Service;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendEmailService
{
    /*
     * mrList is the result of all the projects available on GitLab
     */
    public static function sendEmail($mrList): void
    {
        $content = "<h1>#BalanceTaMR</h1><br><p>Bonjour ! 👋\nVoici les merge requests restantes à ce jour :</p>";
        $content .= "<table>
                      <thead>
                        <tr>
                          <th>Nom 📛</th>
                          <th>Créateur 🧍</th>
                          <th>Date 🗓️</th>
                          <th>Upvotes 👍</th>
                          <th>Downvotes 👎</th>
                          <th>Commentaires 🗨️</th>
                          <th>Lien GitLab 🦊</th>
                        </tr>
                       </thead>
                       <tbody>";

        // mrList contains all the Merge Requests
        // list contains the data of one Merge Request
        foreach ($mrList as $list) {
            foreach ($list as $merge) {
                $content .= "
                <tr>
                   <td>" . $merge['title'] . "</td>
                   <td>" . $merge['author']['name'] . "</td>
                   <td>" . $merge['created_at'] . "</td>
                   <td>" . $merge['upvotes'] . "</td>
                   <td>" . $merge['downvotes'] . "</td>
                   <td>" . $merge['user_notes_count'] . "</td>
                   <td>" . $merge['web_url'] . "</td>
                 </tr>
                ";
            }
        }

        $content .= "</tbody></table>";

        /** @var
         * Dans le terminal , taper la commande : bin/console sendemail:cron
         * Allouer l'accès aux applications non sécurisées sur le dashboard du compte Google
         */
        echo('Sending email with ' . $_ENV['MAIL_ADDR']);
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
            ->setUsername($_ENV['MAIL_ADDR'])
            ->setPassword($_ENV['MAIL_PWD']);


        $mailer = new Swift_Mailer($transport);

        // Creates a message
        $message = (new Swift_Message('Bilan journalier - #BalanceTaMR'))
            ->setFrom(['maxence.lavenu@edu.itescia.fr' => '#BalanceTaMR'])
            ->setTo(['lecarp@hotmail.fr', 'maxence.lavenu@edu.itescia.fr' => 'L\'équipe'])
            ->setBody($content, 'text/html');

        $mailer->send($message);
    }
}