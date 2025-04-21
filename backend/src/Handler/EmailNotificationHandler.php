<?php

namespace App\Handler;

use App\Entity\SubscribedUser;
use App\Generator\QuoteGenerator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
final class EmailNotificationHandler
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly QuoteGenerator $quoteGenerator
    ) {
    }

    public function sendNotification(SubscribedUser $user)
    {
        $quote = $this->quoteGenerator->generateQuote();

        $email = new TemplatedEmail()
            ->from('daily-quotes@tomemming.nl')
            ->to($user->getEmail())
            ->subject('It is time for your daily quote!!')
            ->htmlTemplate('email/quote_email.html.twig')
            ->context([
                'quote' => $quote
            ]);

        $this->mailer->send($email);
    }
}