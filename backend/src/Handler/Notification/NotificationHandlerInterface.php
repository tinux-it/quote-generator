<?php

namespace App\Handler\Notification;

use App\Entity\Subscription;

interface NotificationHandlerInterface
{
    public function sendNotification(Subscription $subscription): void;

    public function getType();
}