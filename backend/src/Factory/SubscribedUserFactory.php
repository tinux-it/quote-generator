<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

final readonly class SubscribedUserFactory
{
    public function __construct(
        private UserRepository         $subscribedUserRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function findUser(string $email): ?User
    {
        return $this->subscribedUserRepository->findOneByEmail($email);
    }
    public function createUser(string $email): User
    {
        $now = new DateTime('now');

        $user = new User();
        $user->setEmail($email);
        $user->setCreatedAt($now);
        $user->setUpdatedAt($now);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
