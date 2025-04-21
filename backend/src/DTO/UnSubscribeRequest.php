<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class UnSubscribeRequest
{
    #[Assert\Email(
        message: 'The email "{{ value }}" is not a valid email.'
    )]
    public string $email;
}
