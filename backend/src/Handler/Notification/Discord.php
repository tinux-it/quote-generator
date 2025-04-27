<?php

declare(strict_types=1);

namespace App\Handler\Notification;

use App\Entity\Subscription;
use App\Generator\QuoteGenerator;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;
use Symfony\Component\Notifier\Bridge\Discord\DiscordOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

final readonly class Discord implements NotificationHandlerInterface
{
    public function __construct(
        private QuoteGenerator $quoteGenerator,
        private ChatterInterface $chatter,
        private LoggerInterface $logger
    ) {
    }

    public function newSubscriberNotification(string $email, DateTimeImmutable $now): void
    {
        $discordOptions = new DiscordOptions()
            ->username('Daily Quote Bot');
        $chatMessage = new ChatMessage(sprintf(
            "🎉 New subscriber to the daily quote app!!
             **%s** joined on %s!",
            $email,
            $now->format('Y-m-d H:i')
        ));

        $chatMessage->options($discordOptions);

        try {
            $this->chatter->send($chatMessage);
        } catch (TransportExceptionInterface $exception) {
            $this->logger->error($exception->getMessage());
        }
    }

    public function sendNotification(Subscription $subscription): void
    {
        // TODO: Workout how to send notifications
        $this->quoteGenerator->generateQuote();
    }

    public function getType(): string
    {
        return 'discord';
    }
}
