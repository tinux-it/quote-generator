<?php

namespace App\Handler;

use App\DTO\SubscribeRequest;
use App\DTO\UnSubscribeRequest;

final class SubscriptionHandler
{
    public function subscribe(SubscribeRequest $request): string
    {
        return "Subscription succesfull!";
    }

    public function unSubscribe(UnSubscribeRequest $request): string
    {
        return "Unsubscription succesfull!";
    }
}