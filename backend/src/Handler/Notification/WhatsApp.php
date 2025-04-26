<?php

declare(strict_types=1);

namespace App\Handler\Notification;

use App\Client\Twillio;
use App\Entity\Subscription;
use App\Generator\QuoteGenerator;

final class WhatsApp implements NotificationHandlerInterface
{
    public function __construct(
        private readonly QuoteGenerator $quoteGenerator,
        private readonly Twillio $twillioClient
    ) {
    }

    public function sendNotification(Subscription $subscription): void
    {
        $quote = $this->quoteGenerator->generateQuote();

        $this->twillioClient->sendMessage($subscription->getDetails(), $quote);
    }

    public function getType(): string
    {
        return 'whatsapp';
    }
}
