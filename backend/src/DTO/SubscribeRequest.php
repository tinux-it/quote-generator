<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class SubscribeRequest
{
    #[Assert\Email(
        message: 'The email "{{ value }}" is not a valid email.')]
    public string $email;

    #[Assert\Length(
        min: 10,
        max: 10,
        minMessage: 'The phone number "{{ value }}" is not valid.',
        maxMessage: 'The phone number "{{ value }}" is not valid.'
    )]
    #[Assert\When(
        expression: 'this.phoneNumber !== null',
        constraints: [
            new Assert\NotBlank(message: 'If provided, the phone number cannot be blank')
        ]
    )]
    public string $phoneNumber;

    #[Assert\NotBlank]
    #[Assert\All([
        new Assert\Choice(choices: ["email", "whatsapp", "browser"])
    ])]
    public array $methods;
}