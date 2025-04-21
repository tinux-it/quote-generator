<?php

namespace App\Handler\Notification\Registry;

use App\Handler\Notification\NotificationHandlerInterface;

final class NotificationHandlerRegistry
{
    private array $handlers = [];

    public function addHandler(NotificationHandlerInterface $handler): void
    {
        $this->handlers[$handler->getType()] = $handler;
    }

    public function getHandler(string $type): ?NotificationHandlerInterface
    {
        return $this->handlers[$type] ?? null;
    }

    public function hasHandler(string $type): bool
    {
        return isset($this->handlers[$type]);
    }
}