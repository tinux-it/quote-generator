<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

final class NewSubscriptionEvent extends Event
{
    public function __construct(
        public User $user,
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
