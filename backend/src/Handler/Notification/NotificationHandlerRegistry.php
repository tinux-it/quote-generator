<?php

namespace App\Handler\Notification;

final class NotificationHandlerRegistry
{
    private array $handlers = [];

    /**
     * @param iterable<NotificationHandlerInterface> $handlers
     */
    public function __construct(iterable $handlers = [])
    {
        foreach ($handlers as $handler) {
            $this->addHandler($handler);
        }
    }


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