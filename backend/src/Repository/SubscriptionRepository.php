<?php

namespace App\Repository;

use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class SubscriptionRepository extends ServiceEntityRepository
{
    public function findOneByUserAndType(User $user, string $type): ?Subscription
    {
        return $this->findOneBy(['user' => $user, 'type' => $type]);

    }


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscription::class);
    }
}