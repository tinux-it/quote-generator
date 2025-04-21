<?php

declare(strict_types=1);

namespace App\Handler\Notification;

use App\Entity\Subscription;
use App\Generator\QuoteGenerator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

final readonly class Email implements NotificationHandlerInterface
{
    public function __construct(
        private MailerInterface $mailer,
        private QuoteGenerator  $quoteGenerator
    ) {
    }

    public function sendNotification(Subscription $subscription): void
    {
        $quote = $this->quoteGenerator->generateQuote();
        $email = new TemplatedEmail()
            ->from('daily-quotes@tomemming.nl')
            ->to($subscription->getDetails())
            ->subject('It is time for your daily quote!!')
            ->htmlTemplate('email/quote_email.html.twig')
            ->context([
                'quote' => $quote,
            ]);

        $this->mailer->send($email);
    }

    public function getType(): string
    {
        return 'email';
    }
}
