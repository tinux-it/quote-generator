<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
final class SubscribedUser
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    private int $id;

    #[Column(type: 'string', length: 255, nullable: false)]
    private string $email;
    #[Column(type: 'json', nullable: false)]
    private array $subscribedTo = [];

    #[Column(type: 'string', length: 10, nullable: true)]
    private string $phoneNumber;

    #[Column(type: 'datetime')]
    private DateTime $createdAt;

    #[Column(type: 'datetime')]
    private DateTime $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getSubscribedTo(): array
    {
        return $this->subscribedTo;
    }

    public function setSubscribedTo(array $subscribedTo): void
    {
        $this->subscribedTo = $subscribedTo;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}