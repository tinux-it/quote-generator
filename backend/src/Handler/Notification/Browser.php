<?php

namespace App\Handler\Notification;

use App\Entity\Subscription;
use App\Generator\QuoteGenerator;

final readonly class Browser implements NotificationHandlerInterface
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

    public function getType()
    {
        return 'browser';
    }
}