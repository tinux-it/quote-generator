<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class SubscribeRequest
{
    #[Assert\Email(
        message: 'The email "{{ value }}" is not a valid email.')]
    public string $email;

    #[Assert\Length(min: 10, max: 10, minMessage: 'The phone number "{{ value }}" is not valid.', maxMessage: 'The phone number "{{ value }}" is not valid.')]
    public string $phoneNumber;

    #[Assert\Choice(choices: ['email', 'whatsapp', 'browser'])]
    public array $methods;
}