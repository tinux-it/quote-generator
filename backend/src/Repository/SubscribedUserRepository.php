<?php

namespace App\Repository;

use App\Entity\SubscribedUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class SubscribedUserRepository extends ServiceEntityRepository
{
    public function findOneByEmail(string $email): ?SubscribedUser
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscribedUser::class);
    }
}