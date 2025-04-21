<?php

namespace App\Command;

use App\Entity\Subscription;
use App\Entity\User;
use App\Handler\Notification\NotificationHandlerRegistry;
use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:notification')]
final class NotificationCommand extends Command
{
    public function __construct(
        private LoggerInterface $logger,
        private readonly UserRepository $userRepository,
        private readonly NotificationHandlerRegistry $handlerRegistry
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->logger->info('Sending notification');

        $users = $this->userRepository->findAll();
        foreach ($users as $user) {
            $this->handleUser($user);
        }

        return Command::SUCCESS;
    }

    private function handleUser(User $user): void
    {
        $subscriptions = $user->getSubscriptions();

        /** @var Subscription $subscription */
        foreach ($subscriptions as $subscription) {
            if ($this->handlerRegistry->hasHandler($subscription->getType())) {
                $handler = $this->handlerRegistry->getHandler($subscription->getType());
                $handler->sendNotification($subscription);
            }
        }
    }


    protected function configure(): void
    {
        $this->setDescription('Send notification');
    }
}