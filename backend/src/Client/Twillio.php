<?php

declare(strict_types=1);

namespace App\Client;

use Psr\Log\LoggerInterface;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

final class Twillio
{
    public function __construct(
        private readonly string $id,
        private readonly string $token,
        private readonly string $fromNumber,
        private readonly LoggerInterface $logger
    ) {
    }

    public function sendMessage(string $recipient, string $message): void
    {
        $client = new Client($this->id, $this->token);
        try {
            $client->messages->create(
                sprintf('whatsapp:%s', $recipient),
                [
                    'from' => sprintf('whatsapp:%s', $this->fromNumber),
                    'body' => $message,
                ]
            );
        } catch (TwilioException $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
