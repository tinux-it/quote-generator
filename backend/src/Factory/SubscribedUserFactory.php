<?php

namespace App\Factory;

use App\Entity\SubscribedUser;
use App\Repository\SubscribedUserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

final readonly class SubscribedUserFactory
{
    public function __construct(
    private SubscribedUserRepository $subscribedUserRepository,
    private EntityManagerInterface $entityManager
    ) {
    }

    public function findOrCreateUser(string $email): SubscribedUser
    {
        $user = $this->subscribedUserRepository->findOneByEmail($email);
        if (!$user instanceof SubscribedUser) {
            $now = new DateTime('now');

            $user = new SubscribedUser();
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