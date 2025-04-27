<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Event\NewSubscriptionEvent;
use App\Handler\Notification\Discord;
use DateTimeImmutable;
use DateTimeZone;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(NewSubscriptionEvent::class)]
final readonly class NewSubscriptionEventListener
{
    public function __construct(
        private Discord $discordHandler
    ) {
    }

    public function __invoke(NewSubscriptionEvent $event): void
    {
        $now = new DateTimeImmutable('now', new DateTimeZone('Europe/Amsterdam'));
        $user = $event->getUser();

        $this->discordHandler->newSubscriberNotification($user->getEmail(), $now);
    }
}
