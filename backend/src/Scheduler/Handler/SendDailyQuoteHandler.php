<?php

declare(strict_types=1);

namespace App\Scheduler\Handler;

use App\Entity\Subscription;
use App\Entity\User;
use App\Handler\Notification\NotificationHandlerInterface;
use App\Handler\Notification\NotificationHandlerRegistry;
use App\Repository\UserRepository;
use App\Scheduler\Message\SendDailyQuote;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SendDailyQuoteHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly LoggerInterface $logger,
        private readonly NotificationHandlerRegistry $handlerRegistry
    ) {
    }

    public function __invoke(SendDailyQuote $message): void
    {
        $this->logger->info('Sending notification');

        $users = $this->userRepository->findAll();
        /** @var User $user */
        foreach ($users as $user) {
            $this->handleUser($user);
        }
    }

    private function handleUser(User $user): void
    {
        $subscriptions = $user->getSubscriptions();

        /** @var Subscription $subscription */
        foreach ($subscriptions as $subscription) {
            if ($this->handlerRegistry->hasHandler($subscription->getType())) {
                $handler = $this->handlerRegistry->getHandler($subscription->getType());
                if (!$handler instanceof NotificationHandlerInterface) {
                    continue;
                }

                $handler->sendNotification($subscription);
            }
        }
    }
}
