<?php

namespace App\Handler\Notification;

use App\Entity\Subscription;
use App\Generator\QuoteGenerator;

final class WhatsApp implements NotificationHandlerInterface
{
    public function __construct(
        private readonly QuoteGenerator $quoteGenerator
    ) {
    }

    public function sendNotification(Subscription $subscription): void
    {
        // TODO: Workout how to send notifications
        $quote = $this->quoteGenerator->generateQuote();
    }

    public function getType()
    {
        return 'whatsapp';
    }
}