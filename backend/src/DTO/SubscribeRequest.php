<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

final class SubscribeRequest
{
    public const array SUBSCRIPTION_METHODS = ["email", "whatsapp", "browser"];

    #[Assert\Email(
        message: 'The email "{{ value }}" is not a valid email.'
    )]
    public string $email;

    /** @var array<string, mixed> $methods */
    #[Assert\NotBlank]
    #[SerializedName("methods")]
    public array $methods = [];

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->email = $data['email'] ?? '';
        $dto->methods = $data['methods'] ?? [];

        return $dto;
    }
}
