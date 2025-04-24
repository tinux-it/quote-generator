<?php

declare(strict_types=1);

namespace App\Handler;

use App\DTO\SubscribeRequest;
use App\DTO\UnSubscribeRequest;
use App\Entity\Subscription;
use App\Entity\User;
use App\Factory\SubscribedUserFactory;
use App\Repository\SubscriptionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

final readonly class SubscriptionHandler
{
    public function __construct(
        private SubscribedUserFactory $subscribedUserFactory,
        private EntityManagerInterface $entityManager,
        private SubscriptionRepository $subscriptionRepository
    ) {
    }


    public function subscribe(SubscribeRequest $request): string
    {
        $user = $this->subscribedUserFactory->findUser($request->email);
        if (!$user instanceof User) {
            $user = $this->subscribedUserFactory->createUser($request->email);

            $this->addSubscriptions($user, $request);
        } else {
            $this->updateSubscription($user, $request);
        }

        return "Created or update subscription successfully!";
    }

    public function unSubscribe(UnSubscribeRequest $request): string
    {
        $user = $this->subscribedUserFactory->findUser($request->email);
        if ($user instanceof User) {
            $this->entityManager->remove($user);

            $this->entityManager->flush();
        }

        return "Unsubscription successful!";
    }

    public function addSubscriptions(User $user, SubscribeRequest $request): void
    {
        $user->setEmail($request->email);
        $user->setUpdatedAt(new DateTime('now'));
        $user = $this->handleSubscriptions($user, $request);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function updateSubscription(User $user, SubscribeRequest $request): void
    {
        $currSubscriptions = $user->getSubscriptions();
        foreach ($currSubscriptions as $subscription) {
            if (!array_key_exists($subscription->getType(), $request->methods)) {
                $user->removeSubscription($subscription);
            }
        }

        $user->setEmail($request->email);
        $user->setUpdatedAt(new DateTime('now'));
        $user = $this->handleSubscriptions($user, $request);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    private function handleSubscriptions(User $user, SubscribeRequest $request): User
    {
        foreach ($request->methods as $methodKey => $methodValue) {
            $subscription = $this->subscriptionRepository->findOneByUserAndType($user, $methodKey);
            if (!$subscription instanceof Subscription) {
                $subscription = new Subscription();
                $subscription->setUser($user);
                $subscription->setType($methodKey);
                $subscription->setDetails(is_string($methodValue) ? $methodValue : sprintf("%s", $methodValue));

                $user->addSubscription($subscription);
            } else {
                $subscription->setDetails(is_string($methodValue) ? $methodValue : sprintf("%s", $methodValue));
            }
        }

        return $user;
    }
}
