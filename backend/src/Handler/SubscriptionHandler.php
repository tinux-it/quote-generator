<?php

namespace App\Handler;

use App\DTO\SubscribeRequest;
use App\DTO\UnSubscribeRequest;
use App\Entity\SubscribedUser;
use App\Factory\SubscribedUserFactory;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

final readonly class SubscriptionHandler
{
    public function __construct(
        private SubscribedUserFactory $subscribedUserFactory,
        private EntityManagerInterface $entityManager
    ) {
    }


    public function subscribe(SubscribeRequest $request): string
    {
        $user = $this->subscribedUserFactory->findOrCreateUser($request->email);
        $this->updateSubscription($user, $request);

        return "Created or update subscription successfully!";
    }

    public function unSubscribe(UnSubscribeRequest $request): string
    {
        return "Unsubscription successful!";
    }

    public function updateSubscription(SubscribedUser $user, SubscribeRequest $request): void
    {
        $user->setEmail($request->email);
        $user->setUpdatedAt(new DateTime('now'));
        $user->setSubscribedTo($request->methods);
        $user->setPhoneNumber($request->phoneNumber);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}