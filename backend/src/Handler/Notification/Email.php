<?php

declare(strict_types=1);

namespace App\Handler\Notification;

use App\Entity\Subscription;
use App\Generator\QuoteGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

final class Email implements NotificationHandlerInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly QuoteGenerator $quoteGenerator,
        private readonly LoggerInterface $logger
    ) {
    }

    public function sendNotification(Subscription $subscription): void
    {
        $quote = $this->quoteGenerator->generateQuote();
        $email = new TemplatedEmail()
            ->from('daily-quotes@tomemming.nl')
            ->to($subscription->getDetails())
            ->subject('It is time for your daily quote!')
            ->htmlTemplate('email/quote_email.html.twig')
            ->context([
                'quote' => $quote,
            ]);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception) {
            $this->logger->error($exception->getMessage());
        }
    }

    public function getType(): string
    {
        return 'email';
    }
}
