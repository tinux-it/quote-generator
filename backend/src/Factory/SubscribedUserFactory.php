<?php

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

    public function findOrCreateUser(string $email): User
    {
        $user = $this->subscribedUserRepository->findOneByEmail($email);
        if (!$user instanceof User) {
            $now = new DateTime('now');

            $user = new User();
            $user->setEmail($email);
            $user->setCreatedAt($now);
            $user->setUpdatedAt($now);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $user;
        }

        return $user;
    }
}