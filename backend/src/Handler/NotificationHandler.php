<?php

namespace App\Handler;

use App\Entity\User;
use App\Repository\SubscribedUserRepository;
use Symfony\Component\Validator\Constraints\Email;

final class NotificationHandler
{
    public function __construct(
        private readonly SubscribedUserRepository $subscribedUserRepository,
        private readonly EmailNotificationHandler $emailNotificationHandler
    ) {
    }

    public function sendNotification(): void
    {
        $users = $this->subscribedUserRepository->findAll();
        foreach ($users as $user) {
            $this->handleUser($user);
        }
    }

    private function handleUser(User $user): void
    {
        $subscriptions = $user->getSubscribedTo();
        foreach ($subscriptions as $subscription) {
            if ($subscription === 'email') {
                $this->emailNotificationHandler->sendNotification($user);
            }
        }
    }
}