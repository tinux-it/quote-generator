<?php

namespace App\DTO;

final class SubscriptionMethod
{
    public string $type;
    public string $value;

    public static function fromArray(string $type, mixed $value): self
    {
        $dto = new self();
        $dto->type = $type;
        $dto->value = $value;

        return $dto;
    }


}