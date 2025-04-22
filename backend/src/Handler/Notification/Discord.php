<?php

declare(strict_types=1);

namespace App\Handler\Notification;

use App\Entity\Subscription;
use App\Generator\QuoteGenerator;

final readonly class Discord implements NotificationHandlerInterface
{
    public function __construct(
        private QuoteGenerator $quoteGenerator
    ) {
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
